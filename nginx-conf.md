    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
    
    location ~* ^/(base|lib)/.*\.php$ {
        return 404;
    }