pipeline {
  agent any

  stages {
    stage('Checkout Code') {
      steps {
        checkout scm
      }
    }

    stage('Check PHP Version') {
      steps {
        script {
          sh 'php -v'
        }
      }
    }

    stage('Check Composer Version') {
      steps {
        script {
          sh 'composer --version'
        }
      }
    }
  }

  post {
    always {
      cleanWs()
    }
  }
}
