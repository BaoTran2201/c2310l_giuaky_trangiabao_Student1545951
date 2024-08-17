CREATE DATABASE library_db;
USE library_db;

CREATE TABLE authors (
    id INT AUTO_INCREMENT PRIMARY KEY,
    author_name VARCHAR(255) NOT NULL,
    book_numbers INT NOT NULL
);

CREATE TABLE categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_name VARCHAR(255) NOT NULL
);

CREATE TABLE books (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    author_id INT NOT NULL,
    category_id INT NOT NULL,
    publisher VARCHAR(255) NOT NULL,
    publish_year YEAR NOT NULL,
    quantity INT NOT NULL,
    FOREIGN KEY (author_id) REFERENCES authors(id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);


INSERT INTO authors (author_name, book_numbers) VALUES 
('J.K. Rowling', 7),
('George Orwell', 4),
('Jane Austen', 5),
('Mark Twain', 10),
('Ernest Hemingway', 9),
('F. Scott Fitzgerald', 3),
('Charles Dickens', 15),
('Leo Tolstoy', 12),
('Fyodor Dostoevsky', 11),
('Gabriel Garcia Marquez', 8),
('Harper Lee', 1),
('J.R.R. Tolkien', 6),
('Agatha Christie', 66),
('Stephen King', 63),
('Arthur Conan Doyle', 4),
('H.G. Wells', 2),
('Isaac Asimov', 50),
('Philip K. Dick', 44),
('Edgar Allan Poe', 70),
('Mary Shelley', 2);


INSERT INTO categories (category_name) VALUES 
('Fantasy'),
('Science Fiction'),
('Mystery'),
('Romance'),
('Horror'),
('Historical Fiction'),
('Thriller'),
('Adventure'),
('Non-Fiction'),
('Classic Literature');


ALTER TABLE books MODIFY publish_year INT;


INSERT INTO books (title, author_id, category_id, publisher, publish_year, quantity) VALUES 
('Harry Potter and the Sorcerer\'s Stone', 1, 1, 'Bloomsbury', 1997, 50),
('1984', 2, 2, 'Secker & Warburg', 1949, 30),
('Pride and Prejudice', 3, 4, 'T. Egerton', 1813, 40),
('The Adventures of Tom Sawyer', 4, 8, 'American Publishing Company', 1876, 25),
('The Old Man and the Sea', 5, 9, 'Charles Scribner\'s Sons', 1952, 20),
('The Great Gatsby', 6, 7, 'Charles Scribner\'s Sons', 1925, 15),
('A Tale of Two Cities', 7, 6, 'Chapman & Hall', 1859, 10),
('War and Peace', 8, 9, 'The Russian Messenger', 1869, 12),
('Crime and Punishment', 9, 9, 'The Russian Messenger', 1866, 18),
('One Hundred Years of Solitude', 10, 6, 'Harper & Row', 1967, 22),
('To Kill a Mockingbird', 11, 3, 'J.B. Lippincott & Co.', 1960, 28),
('The Lord of the Rings', 12, 1, 'George Allen & Unwin', 1954, 32),
('Murder on the Orient Express', 13, 3, 'Collins Crime Club', 1934, 35),
('The Shining', 14, 5, 'Doubleday', 1977, 27),
('The Hound of the Baskervilles', 15, 3, 'George Newnes', 1902, 21),
('The Time Machine', 16, 2, 'Heinemann', 1895, 19),
('Foundation', 17, 2, 'Gnome Press', 1951, 40),
('Do Androids Dream of Electric Sheep?', 18, 2, 'Doubleday', 1968, 36),
('The Raven', 19, 5, 'The American Review', 1845, 60),
('Frankenstein', 20, 5, 'Lackington, Hughes, Harding, Mavor & Jones', 1818, 50);

