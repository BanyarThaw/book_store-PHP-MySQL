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
        // stage("Testing") {
        //     steps {
        //         sh '''
        //             pwd
        //         '''
        //     }
        // }
        stage("Go to project directory") {
            steps {
                sshagent(credentials: ['awslightsail']) {
                    sh 'ssh -o StrictHostKeyChecking=no ubuntu@54.255.246.163 cd projects/book_store-PHP-MySQL'
                    sh 'pwd'
                    sh 'ls'
                    sh 'sudo git pull origin dev_branc_ubuntu'
                }
            }
        }
        // stage("Git pull branch") {
        //     steps {
        //         sh '''
        //             git pull origin main
        //         '''
        //     }
        // }
    }
}