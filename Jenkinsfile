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
                //sh 'composer install --no-interaction --prefer-dist --optimize-autoloader'
                sh '/usr/local/bin/composer install'

            }
        }

        stage('Run Tests') {
            steps {
                // Run PHP Unit tests
                sh 'php artisan test --no-interaction'
            }
        }

//         stage('Static Analysis') {
//             steps {
//                 // Run PHP CodeSniffer or other static analysis tools
//                 sh 'vendor/bin/phpcs --standard=PSR12 app/'
//             }
//         }

//         stage('Build Frontend') {
//             steps {
//                 // Install Node.js dependencies and build frontend assets
//                 sh 'npm install'
//                 sh 'npm run production'
//             }
//         }

//         stage('Deploy') {
//             steps {
//                 // Optional deployment steps
//                 echo 'Deployment steps here'
//             }
//         }
    }

//     post {
//         always {
//             // Cleanup actions
//             sh 'composer clear-cache'
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
