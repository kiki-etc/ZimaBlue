CREATE DATABASE JudicialManagementSystem;
USE JudicialManagementSystem;

CREATE TABLE Users (
    UserID INT PRIMARY KEY AUTO_INCREMENT,
    Username VARCHAR(50) NOT NULL UNIQUE,
    PasswordHash VARCHAR(255) NOT NULL,
    Email VARCHAR(100) NOT NULL UNIQUE,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Roles (
    RoleID INT PRIMARY KEY AUTO_INCREMENT,
    RoleName VARCHAR(20) NOT NULL UNIQUE
);

CREATE TABLE UserRoles (
    UserRoleID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    RoleID INT,
    FOREIGN KEY (UserID) REFERENCES Users(UserID),
    FOREIGN KEY (RoleID) REFERENCES Roles(RoleID)
);

CREATE TABLE Cases (
    CaseID INT PRIMARY KEY AUTO_INCREMENT,
    CaseNumber VARCHAR(50) NOT NULL UNIQUE,
    Title VARCHAR(255) NOT NULL,
    Description TEXT,
    Status VARCHAR(20) DEFAULT 'pending', -- Add Status column
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CreatedBy INT,
    FOREIGN KEY (CreatedBy) REFERENCES Users(UserID)
);

CREATE TABLE ComplaintsSuggestions (
    ComplaintSuggestionID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    Title VARCHAR(255) NOT NULL,
    Description TEXT NOT NULL,
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Status VARCHAR(50) DEFAULT 'Pending',
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

CREATE TABLE Documents (
    DocumentID INT PRIMARY KEY AUTO_INCREMENT,
    CaseID INT,
    UploadedBy INT,
    DocumentName VARCHAR(255) NOT NULL,
    DocumentPath VARCHAR(255) NOT NULL,
    UploadDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (CaseID) REFERENCES Cases(CaseID),
    FOREIGN KEY (UploadedBy) REFERENCES Users(UserID)
);

INSERT INTO Roles (RoleName) VALUES ('superadmin'), ('admin'), ('user');
