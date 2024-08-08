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
    Status VARCHAR(20) DEFAULT 'pending',
    CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CreatedBy INT,
    FOREIGN KEY (CreatedBy) REFERENCES Users(UserID)
);

CREATE TABLE CaseProsecutors (
    CaseProsecutorID INT PRIMARY KEY AUTO_INCREMENT,
    CaseID INT,
    UserID INT,
    FOREIGN KEY (CaseID) REFERENCES Cases(CaseID),
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

CREATE TABLE CaseDefendants (
    CaseDefendantID INT PRIMARY KEY AUTO_INCREMENT,
    CaseID INT,
    UserID INT,
    FOREIGN KEY (CaseID) REFERENCES Cases(CaseID),
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
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

CREATE TABLE Activities (
    ActivityID INT PRIMARY KEY AUTO_INCREMENT,
    UserID INT,
    ActivityDate TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    Description TEXT,
    FOREIGN KEY (UserID) REFERENCES Users(UserID)
);

INSERT INTO Roles (RoleName) VALUES ('superadmin'), ('admin'), ('user');

-- Insert the superadmin user into the Users table
INSERT INTO Users (Username, PasswordHash, Email)
VALUES ('superadmin', '$2y$10$ztvGOnEMx/75/6Fgn3hKkuNALgrlOo9vykYvSg5eyo0B8sS83ydmm', 'superadmin@ashesi.edu.gh');

-- Get the UserID of the inserted superadmin user
SELECT UserID FROM Users WHERE Username = 'superadmin';

-- (Manually find the UserID from the result of the above query. Suppose the UserID is 1.)

-- Get the RoleID of the superadmin role
SELECT RoleID FROM Roles WHERE RoleName = 'superadmin';

-- (Manually find the RoleID from the result of the above query. Suppose the RoleID is 1.)

-- Insert the UserID and RoleID into the UserRoles table
INSERT INTO UserRoles (UserID, RoleID)
VALUES (1, 1);

INSERT INTO Users (Username, PasswordHash, Email) VALUES ('kikietc', '$2y$12$A86EC7v8QTQX6.qdnJG9V.5IrfcfQrAqlq4By1gCSZjQYuHiiLqWm', 'kiki.etc@icloud.com');