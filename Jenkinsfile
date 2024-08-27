pipeline {
    agent any


    environment {
        COMPOSER_BIN = '/usr/local/bin/composer'
        PHP_BIN = '/Users/jahidulislam/Library/Application Support/Herd/bin/php'
        COMPOSER_CACHE_DIR = "${HOME}/.composer/cache"
    }

    stages {
        stage('Checkout') {
            steps {
                git branch: 'main', url: 'https://github.com/Jahiduldev/laravelBoilerplate.git'
            }
        }

        stage('Install Dependencies') {
            steps {
                // Set the PATH environment variable to include the PHP_BIN directory
                sh "export PATH='${env.PHP_BIN%/*}':\$PATH && ${env.COMPOSER_BIN} install --no-interaction --prefer-dist --optimize-autoloader"
            }
        }


//         stage('Run Tests') {
//             steps {
//                 // Run PHP Unit tests
//                 sh "${env.PHP_BIN} artisan test --no-interaction"
//             }
//         }
    }

    post {
//         always {
//             // Cleanup actions
//             sh "${env.COMPOSER_BIN} clear-cache"
//             deleteDir()
//         }

        success {
            // Actions to perform on success
            echo 'Pipeline completed successfully!'
        }

        failure {
            // Actions to perform on failure
            echo 'Pipeline failed. Check the logs for details.'
        }
    }
}
