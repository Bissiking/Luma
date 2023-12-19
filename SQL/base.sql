CREATE TABLE routes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    url_pattern VARCHAR(255) NOT NULL,
    controller VARCHAR(255) NOT NULL,
    action VARCHAR(255) NOT NULL
);

INSERT INTO routes (url_pattern, controller, action) VALUES
    ('/accueil', 'HomeController', 'index'),
    ('/contact', 'ContactController', 'show');

