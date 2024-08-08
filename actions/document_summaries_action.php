<?php
include "../settings/core.php";
include "../settings/connection.php";
require '../vendor/autoload.php'; // Autoload for dependencies

use Smalot\PdfParser\Parser;

function summarize_text($text) {
    $url = "https://api.ai21.com/studio/v1/summarize";
    $apiKey = "9KKqGNbFGmdrjH4Mfh0mjPGIak7cLpgY";
    
    $data = [
        "source" => $text,
        "sourceType" => "TEXT",
        "max_length" => 100  // Specify the maximum length of the summary in words
    ];
    
    $options = [
        "http" => [
            "header" => "Content-type: application/json\r\n" .
                        "Authorization: Bearer $apiKey\r\n",
            "method" => "POST",
            "content" => json_encode($data),
        ],
    ];
    
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) {
        return "Error in summarizing text.";
    }

    $response = json_decode($result, true);
    return $response['summary'] ?? "Summary not available.";
}

function generate_title($text) {
    $url = "https://api.ai21.com/studio/v1/complete";
    $apiKey = "9KKqGNbFGmdrjH4Mfh0mjPGIak7cLpgY";
    
    $data = [
        "prompt" => "Generate a title for the following text:\n\n$text\n\nTitle:",
        "numResults" => 1,
        "maxTokens" => 10,
        "temperature" => 0.5,
        "topKReturn" => 0,
        "topP" => 1
    ];
    
    $options = [
        "http" => [
            "header" => "Content-type: application/json\r\n" .
                        "Authorization: Bearer $apiKey\r\n",
            "method" => "POST",
            "content" => json_encode($data),
        ],
    ];
    
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);
    if ($result === FALSE) {
        return "Error in generating title.";
    }

    $response = json_decode($result, true);
    return $response['completions'][0]['data']['text'] ?? "Title not available.";
}

$parser = new Parser();
$documentQuery = "SELECT DocumentID, DocumentName, DocumentPath FROM Documents";
$documentResult = $conn->query($documentQuery);

$documentSummaries = [];
if ($documentResult->num_rows > 0) {
    while ($document = $documentResult->fetch_assoc()) {
        $documentPath = "../uploads/" . $document['DocumentPath'];
        if (file_exists($documentPath)) {
            try {
                $pdf = $parser->parseFile($documentPath);
                $documentContent = $pdf->getText();
                $summary = summarize_text($documentContent);
                $title = generate_title($documentContent);
                $documentSummaries[] = [
                    "DocumentID" => $document['DocumentID'],
                    "DocumentName" => $document['DocumentName'],
                    "Title" => $title,
                    "Summary" => $summary,
                ];
            } catch (Exception $e) {
                $documentSummaries[] = [
                    "DocumentID" => $document['DocumentID'],
                    "DocumentName" => $document['DocumentName'],
                    "Title" => "Error generating title.",
                    "Summary" => "Error parsing document.",
                ];
            }
        } else {
            $documentSummaries[] = [
                "DocumentID" => $document['DocumentID'],
                "DocumentName" => $document['DocumentName'],
                "Title" => "Document not found.",
                "Summary" => "Document not found.",
            ];
        }
    }
}

header('Content-Type: application/json');
echo json_encode($documentSummaries);