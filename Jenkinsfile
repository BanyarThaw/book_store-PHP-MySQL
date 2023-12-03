pipeline {
    agent any
    environment {
        /*
        define your command in variable
        */
        remoteCommands =
        """
            cd projects/book_store-PHP-MySQL;ls -l;
            echo "Hello, world!";
            pwd;
            sudo git pull origin dev_branc_ubuntu
        """
    }
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
        stage("Go to project directory and pull the git branch") {
            steps {
                sshagent(credentials: ['awslightsail']) {
                    sh 'ssh -o StrictHostKeyChecking=no ubuntu@54.255.246.163 $remoteCommands'
                }
            }
        }
    }
}