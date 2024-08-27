pipeline {
    agent any

    stages {
        stage('Install Dependencies') {
            steps {
                script {
                    // Ensure Composer is installed and install PHP dependencies
                    sh 'composer install --no-interaction --prefer-dist --optimize-autoloader'
                }
            }
        }

        stage('Build Frontend') {
            steps {
                script {
                    // Install Node.js dependencies and build frontend assets
                    sh 'npm install'
                    sh 'npm run prod'
                }
            }
        }
    }

    post {
        always {
            script {
                // Clean up workspace after build
                cleanWs()
            }
        }
        success {
            script {
                echo 'Build completed successfully!'
            }
        }
        failure {
            script {
                echo 'Build failed.'
            }
        }
    }
}
