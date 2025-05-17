<?php
    require_once __DIR__ . '/../models/applicant.php';
    class ApplicationFormController{
        public function showFiveApplicants(){
            $application = new Applicant();
            $applications = $application->showApplicant();
            include_once __DIR__ . '/../views/application_form.php';
        }

        public function saveApplication(){
            $data = json_decode(file_get_contents('php://input'), true);

            $error = [];

            if(empty($data['name'])){
                $error[] = 'Please provide a name';
            }

            if(empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                $error[] = 'Invalid Email';
            }

            $portfolio = null;
            if(!empty($data['portfolio'])){
                $url = trim($data['portfolio']);

                if(!preg_match('#^https?://#i', $url)){
                    $url = 'http://' . $url;
                }

                if(!filter_var($url, FILTER_VALIDATE_URL)){
                    $error[] = 'Invalid URL';
                }else{
                    $portfolio = $url;
                }
            }

            if(empty($data['letter']) || strlen($data['letter']) < 20){
                $error[] = 'Cover letter must be atleast 20 characters';
            }

            if(!empty($error)){
                http_response_code(422);
                echo json_encode([
                    'success' => false,
                    'message' => $error
                ]);
                return;
            }
            
            $application = new Applicant();
            $application->saveApplication($data['name'], $data['email'], $portfolio, $data['letter']);

            echo json_encode([
                'success' => true,
                'message' => 'Application Submitted',
                'applicationEntry' => [
                    'name' => htmlspecialchars($data['name']),
                    'email' => htmlspecialchars($data['email']),
                    'portfolio' => htmlspecialchars($portfolio ?? ''),
                    'letter' => htmlspecialchars($data['letter']),
                    'date' => date('Y-m-d H:i:s')
                ]
            ]);
        }
    }
?>