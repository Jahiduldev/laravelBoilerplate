pipeline {
    agent any

    environment {
        // Define your environment variables here
        COMPOSER_CACHE_DIR = "${HOME}/.composer/cache"
    }

    stages {
        stage('Checkout') {
            steps {
                // Checkout the code from the repository
                git branch: 'main', url: 'https://github.com/Jahiduldev/laravelBoilerplate.git'
            }
        }

        stage('Install Dependencies') {
            steps {
                // Install PHP dependencies using Composer
                sh '/Users/jahidulislam/.composer/vendor/bin/composer install --no-interaction --prefer-dist --optimize-autoloader'
            }
        }

        stage('Run Tests') {
            steps {
                // Run PHP Unit tests
                sh '/Users/jahidulislam/Library/Application\\ Support/Herd/bin/php artisan test --no-interaction'
            }
        }
    }

//     post {
//         always {
//             // Cleanup actions
//             sh '/Users/jahidulislam/.composer/vendor/bin/composer clear-cache'
//             deleteDir()
//         }
//
//         success {
//             // Actions to perform on success
//             echo 'Pipeline completed successfully!'
//         }
//
//         failure {
//             // Actions to perform on failure
//             echo 'Pipeline failed. Check the logs for details.'
//         }
//     }
}
