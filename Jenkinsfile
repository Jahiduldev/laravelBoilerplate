pipeline {
    agent any

    environment {
        // Define environment variables with your standard PHP and Composer paths
        PHP_BIN = '/usr/bin/php'  // Adjust this to the correct PHP binary path if necessary
        COMPOSER_BIN = '/usr/local/bin/composer'
    }

    stages {
        stage('Install Dependencies') {
            steps {
                script {
                    sh "${PHP_BIN} ${COMPOSER_BIN} install --no-interaction --prefer-dist"
                }
            }
        }

        stage('Run Tests') {
            steps {
                script {
                    sh "${PHP_BIN} artisan test"
                }
            }
        }

        stage('Build Application') {
            steps {
                script {
                    // Add any specific build steps here
                    echo 'Building application...'
                }
            }
        }

        stage('Clear Cache') {
            steps {
                script {
                    sh "${PHP_BIN} artisan config:cache"
                    sh "${PHP_BIN} artisan route:cache"
                    sh "${PHP_BIN} artisan view:cache"
                }
            }
        }

        stage('Deploy') {
            steps {
                script {
                    // Add your deployment commands here
                    echo 'Deploying application...'
                }
            }
        }
    }

    post {
        always {
            script {
                echo 'Pipeline completed.'
            }
        }

        success {
            script {
                echo 'Pipeline succeeded.'
            }
        }

        failure {
            script {
                echo 'Pipeline failed.'
            }
        }
    }
}
