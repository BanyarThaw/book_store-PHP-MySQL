pipeline {
    agent any
    stages {
        stage("Verify SSH connection to server") {
            steps {
                sshagent(credentials: ['awslightsail']) {
                    sh '''
                        ssh -o StrictHostKeyChecking=no ubuntu@54.255.246.163 whoami
                    '''
                }
            }
        }     
        stage("Verify tooling") {
            steps {
                sh '''
                    docker info
                    docker version
                    docker compose version
                '''
            }
        }   
        stage("Testing") {
            steps {
                sh '''
                    echo "Hello Wrold"
                '''
            }
        }
        // stage("Go to project directory") {
        //     steps {
        //         sh 'cd "~/projects/book_store-PHP-MySQL"'
        //     }
        // }
        // stage("Git pull branch") {
        //     steps {
        //         sh 'git pull origin main'
        //     }
        // }
    }
}