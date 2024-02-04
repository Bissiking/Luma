CREATE TABLE roles (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE permissions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE role_permissions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    role_id INT,
    permission_id INT,
    FOREIGN KEY (role_id) REFERENCES roles(id),
    FOREIGN KEY (permission_id) REFERENCES permissions(id)
);

INSERT INTO roles (name) VALUES ('admin'), ('editor'), ('user');
INSERT INTO permissions (name) VALUES ('manage_users'), ('manage_content'), ('view_content');

function hasPermission($userId, $requiredPermission) {
    // Exécutez une requête SQL pour vérifier si l'utilisateur a la permission
    // (Assurez-vous de sécuriser correctement vos requêtes SQL pour éviter les injections SQL)
    $query = "SELECT COUNT(*) AS count
              FROM users
              JOIN user_roles ON users.id = user_roles.user_id
              JOIN role_permissions ON user_roles.role_id = role_permissions.role_id
              JOIN permissions ON role_permissions.permission_id = permissions.id
              WHERE users.id = :userId AND permissions.name = :requiredPermission";

    // Exécutez la requête avec PDO ou une autre bibliothèque de requêtes SQL
    // Assurez-vous de sécuriser correctement vos requêtes SQL pour éviter les injections SQL
    // ...

    // Retourne vrai si l'utilisateur a la permission, sinon faux
    return $result['count'] > 0;
}
