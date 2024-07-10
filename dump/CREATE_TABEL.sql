
-- ------------------------------------------------
-- ________________ _____________________.____     
-- \__    ___/  _  \\______   \_   _____/|    |    
--   |    | /  /_\  \|    |  _/|    __)_ |    |    
--   |    |/    |    \    |   \|        \|    |___ 
--   |____|\____|__  /______  /_______  /|_______ \
--                 \/       \/        \/         \/
-- ------------------------------------------------

-- Membuat 7 tabel 

CREATE TABLE Users (
    Username VARCHAR(50) PRIMARY KEY,
    NAME VARCHAR(100) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    PASSWORD VARCHAR(100) NOT NULL,
    PhotoProfile VARCHAR(255),
    Bio VARCHAR(255)
);

CREATE TABLE Posts (
    PostID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(50) NOT NULL,
    Image VARCHAR(255) NOT NULL,
    DESCRIPTION TEXT,
    DATETIME DATETIME,
    FOREIGN KEY (Username) REFERENCES Users(Username)
);

CREATE TABLE StatusUpdate (
    StatusID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(50) NOT NULL,
    Image VARCHAR(255) NOT NULL,
    DATETIME DATETIME,
    FOREIGN KEY (Username) REFERENCES Users(Username)
);

CREATE TABLE Follows (
    FollowID INT AUTO_INCREMENT PRIMARY KEY,
    FollowerUsername VARCHAR(50) NOT NULL,
    FollowedUsername VARCHAR(50) NOT NULL,
    FOREIGN KEY (FollowerUsername) REFERENCES Users(Username),
    FOREIGN KEY (FollowedUsername) REFERENCES Users(Username),
    UNIQUE (FollowerUsername, FollowedUsername)
);

CREATE TABLE Comments (
    CommentID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(50) NOT NULL,
    PostID INT NOT NULL,
    Content TEXT,
    Likes INT DEFAULT 0,
    DATETIME DATETIME,
    ReplyToCommentID INT,
    FOREIGN KEY (Username) REFERENCES Users(Username),
    FOREIGN KEY (PostID) REFERENCES Posts(PostID),
    FOREIGN KEY (ReplyToCommentID) REFERENCES Comments(CommentID)
);

CREATE TABLE Likes (
    LikeID INT AUTO_INCREMENT PRIMARY KEY,
    PostID INT NOT NULL,
    Username VARCHAR(50) NOT NULL,
    FOREIGN KEY (PostID) REFERENCES Posts(PostID),
    FOREIGN KEY (Username) REFERENCES Users(Username),
    UNIQUE (PostID, Username)
);

CREATE TABLE Notifications (
    NotificationID INT AUTO_INCREMENT PRIMARY KEY,
    Username VARCHAR(50),
    Message TEXT NOT NULL,
    DATETIME DATETIME,
    FOREIGN KEY (Username) REFERENCES Users(Username)
);

CREATE TABLE Rooms (
    RoomID INT AUTO_INCREMENT PRIMARY KEY,
    RoomName VARCHAR(255) NOT NULL,
    Description VARCHAR(255),
    VideoPath VARCHAR(255) NOT NULL,
    CurrentTime INT DEFAULT 0
);

CREATE TABLE CommentsRoom (
    CommentID INT AUTO_INCREMENT PRIMARY KEY,
    RoomID INT,
    Username INT,
    Message TEXT,
    Timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (RoomID) REFERENCES rooms(RoomID)
);

CREATE TABLE Videos (
    VideoID INT AUTO_INCREMENT PRIMARY KEY,
    Uploader VARCHAR(255),
    Video VARCHAR(255),
    DESCRIPTION TEXT,
    DATETIME DATETIME,
    FOREIGN KEY (Uploader) REFERENCES Users(Username)
);

-- Tambahkan data dummy ke tabel rooms
INSERT INTO rooms (RoomName, VideoPath) VALUES
('Room A', 'videos/roomA.mp4'),
('Room B', 'videos/roomB.mp4'),
('Room C', 'videos/roomC.mp4');

-- Tambahkan data dummy ke tabel commentsroom
INSERT INTO commentsroom (RoomID, Username, Message) VALUES
(1, 1, 'Ini adalah komentar untuk Room A'),
(2, 2, 'Ini adalah komentar untuk Room B'),
(3, 3, 'Ini adalah komentar untuk Room C');


-- tidak dipakai

CREATE TABLE videos (
    VideoID INT AUTO_INCREMENT PRIMARY KEY,
    Title VARCHAR(255) NOT NULL,
    Url VARCHAR(255) NOT NULL,
    CurrentTime INT DEFAULT 0
);

-- Insert data

INSERT INTO Users (Username, NAME, Email, PASSWORD, PhotoProfile, Bio) VALUES
('john_doe', 'John Doe', 'john.doe@example.com', 'securepassword123', 'profile1.jpg', 'Software developer and tech enthusiast.'),
('jane_smith', 'Jane Smith', 'jane.smith@example.com', 'password123', 'profile2.jpg', 'Loves photography and travel.'),
('alice_jones', 'Alice Jones', 'alice.jones@example.com', 'mysecurepassword', 'profile3.jpg', 'Digital marketer and content creator.');

INSERT INTO Posts (Username, Image, DESCRIPTION, DATETIME) VALUES
('john_doe', 'post1.jpg', 'A beautiful sunset over the mountains.', '2024-06-01 18:30:00'),
('jane_smith', 'post2.jpg', 'Exploring the city streets at night.', '2024-06-02 20:00:00'),
('alice_jones', 'post3.jpg', 'Delicious homemade pasta.', '2024-06-03 12:15:00');

INSERT INTO StatusUpdate (Username, Image, DATETIME) VALUES
('john_doe', 'status1.jpg', '2024-06-01 08:00:00'),
('jane_smith', 'status2.jpg', '2024-06-02 09:30:00'),
('alice_jones', 'status3.jpg', '2024-06-03 10:45:00');

INSERT INTO FOLLOWS (FollowerUsername, FollowedUsername) VALUES
('john_doe', 'jane_smith'),
('jane_smith', 'alice_jones'),
('alice_jones', 'john_doe');

INSERT INTO Comments (Username, PostID, Content, DATETIME) VALUES
('jane_smith', 1, 'Amazing view! Love the colors.', '2024-06-01 19:00:00'),
('alice_jones', 2, 'Great shot! The lighting is perfect.', '2024-06-02 21:00:00'),
('john_doe', 3, 'That looks delicious! Recipe please?', '2024-06-03 12:30:00');

INSERT INTO Likes (PostID, Username) VALUES
(1, 'jane_smith'),
(1, 'alice_jones'),
(2, 'john_doe');

INSERT INTO Notifications (Username, Message, DATETIME) VALUES
('john_doe', 'You have a new follower: jane_smith.', '2024-06-01 18:35:00'),
('jane_smith', 'You have a new follower: alice_jones.', '2024-06-02 20:05:00'),
('alice_jones', 'You have a new follower: john_doe.', '2024-06-03 12:20:00');


-- ------------------------------------------------
-- ________   ____ _____________________________.___.
-- \_____  \ |    |   \_   _____/\______   \__  |   |
--  /  / \  \|    |   /|    __)_  |       _//   |   |
-- /   \_/.  \    |  / |        \ |    |   \\____   |
-- \_____\ \_/______/ /_______  / |____|_  // ______|
--        \__>                \/         \/ \/       
-- ------------------------------------------------

-- Membuat Query


-- 1. Query Kompleks
--  Query Kompleks untuk menampilkan informasi postingan diurutkan berdasarkan jumlah like
SELECT 
    p.PostID,
    p.Username,
    p.Image,
    p.DESCRIPTION,
    p.DATETIME,
    u.Name AS UserName,
    u.Email AS UserEmail,
    COUNT(l.LikeID) AS LikeCount
FROM Posts p
JOIN Users u ON p.Username = u.Username
LEFT JOIN Likes l ON p.PostID = l.PostID
GROUP BY p.PostID
ORDER BY LikeCount DESC;

-- Query kompleks untuk menampilkan User dengan jumlah followers terbanyak
SELECT 
    u.Username,
    u.Name,
    u.Email,
    COUNT(f.FollowedUsername) AS FollowerCount
FROM Users u
JOIN FOLLOWS f ON u.Username = f.FollowedUsername
GROUP BY u.Username, u.Name, u.Email
ORDER BY FollowerCount DESC
LIMIT 1;


-- 2. View
-- View ini menggabungkan informasi dari tabel Comments, Posts, dan Users untuk menyediakan tampilan lengkap tentang komentar beserta informasi terkait
CREATE VIEW ViewComments AS
SELECT 
    Comments.CommentID,
    Comments.Content,
    Comments.DATETIME AS CommentDateTime,
    Posts.PostID,
    Posts.Image AS PostImage,
    Posts.DESCRIPTION AS PostDescription,
    Posts.DATETIME AS PostDateTime,
    Users.Username AS CommenterUsername,
    Users.Name AS CommenterName,
    Users.Email AS CommenterEmail
FROM Comments
JOIN Posts ON Comments.PostID = Posts.PostID
JOIN Users ON Comments.Username = Users.Username;

SELECT * FROM viewcomments;

-- View ini digunakan untuk menampilkan semua postingan dan informasi user yang memposting
CREATE VIEW ViewPosts AS
SELECT 
    Posts.PostID,
    Posts.Image,
    Posts.DESCRIPTION,
    Posts.DATETIME,
    Users.Username,
    Users.Name,
    Users.Email
FROM Posts
JOIN Users ON Posts.Username = Users.Username;
SELECT * FROM viewPosts;

-- View ini digunakan untuk menampilkan semua status dan informasi user yang mengupdate status
CREATE VIEW ViewStatusUpdates AS
SELECT 
    su.StatusID,
    su.Username,
    su.Image,
    su.DATETIME,
    u.Name AS FullName,
    u.Email AS UserEmail,
    u.PhotoProfile AS UserProfilePhoto,
    u.Bio AS UserBio
FROM StatusUpdate su
JOIN Users u ON su.Username = u.Username;
SELECT * FROM viewStatusUpdates;




-- 3. Function
-- Fungsi ini menghitung jumlah followers untuk username yang diberikan
DELIMITER //

CREATE FUNCTION GetFollowerCount(USER VARCHAR(50))
RETURNS INT
BEGIN
    DECLARE followerCount INT;

    SELECT COUNT(*) INTO followerCount
    FROM FOLLOWS
    WHERE FollowedUsername = USER;

    RETURN followerCount;
END //

DELIMITER ;


-- Fungsi ini menampilkan jumlah like dari suatu postingan berdasarkan PostID
DELIMITER //

CREATE FUNCTION GetPostLikeCount(p_PostID INT)
RETURNS INT
BEGIN
    DECLARE likeCount INT;
    
    SELECT COUNT(*) INTO likeCount
    FROM Likes
    WHERE PostID = p_PostID;
    
    RETURN likeCount;
END //

DELIMITER ;


-- 4. Procedure
-- Prosedur ini digunakan untuk menampilkan status yang di update dari user yang di follow
DELIMITER //
CREATE PROCEDURE GetFollowedUsersStatusUpdates(
    IN p_Username VARCHAR(50)
)
BEGIN
    SELECT 
        su.StatusID,
        su.Username,
        su.Image,
        su.DATETIME,
        u.Name
    FROM StatusUpdate su
    JOIN FOLLOWS f ON su.Username = f.FollowedUsername
    JOIN Users u ON su.Username = u.Username
    WHERE f.FollowerUsername = p_Username
    ORDER BY su.DATETIME DESC;
END //
DELIMITER ;

-- Prosedur ini digunakan untuk menambahkan like pada postingan dengan membatasi satu user hanya dapat melakukan like 1 kali
DELIMITER //
CREATE PROCEDURE LikePost(
    IN p_PostID INT,
    IN p_Username VARCHAR(50)
)
BEGIN
    IF NOT EXISTS (
        SELECT 1
        FROM Likes 
        WHERE PostID = p_PostID AND Username = p_Username
    ) THEN
        INSERT INTO Likes (PostID, Username)
        VALUES (p_PostID, p_Username);
    END IF;
END //
DELIMITER ;

-- 5. Trigger
-- Trigger untuk mengupdate kolom DateTime menjadi waktu saat melakukan insert post
DELIMITER //
CREATE TRIGGER BeforePostInsert
BEFORE INSERT ON Posts
FOR EACH ROW
BEGIN
    SET NEW.DATETIME = NOW();
END //
DELIMITER ;

-- Trigger untuk menambahkan pesan notifikasi didalam tabel notification
DELIMITER //
CREATE OR REPLACE TRIGGER after_follow_insert
AFTER INSERT ON FOLLOWS
FOR EACH ROW
BEGIN
    DECLARE notificationMessage TEXT;
    SET notificationMessage = CONCAT(NEW.FollowerUsername, ' telah mengikuti kamu.');
    INSERT INTO Notifications (Username, Message, DATETIME) VALUES (NEW.FollowedUsername, notificationMessage, NOW());
END //
DELIMITER ;
