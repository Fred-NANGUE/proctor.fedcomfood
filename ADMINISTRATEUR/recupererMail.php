<?php
function recuperer_mail(){
$server = '{imap.gmail.com:993/imap/ssl}INBOX';
$username = 'fredmiguelnanguefeulefack@gmail.com';
$password = 'lljllmxawcfvxafx';
// sent,imp,all,
 $mailbox = imap_open($server , $username, $password);
$mails = FALSE;
            if (FALSE === $mailbox) {
                $message = 'La connexion a échoué. Vérifiez vos paramètres!';                
            } else {  
                $info = imap_check($mailbox);
            if (FALSE !== $info) {
// le nombre de messages affichés est entre 1 et 50
// libre à vous de modifier ce paramètre
             $mails = imap_fetch_overview($mailbox, '1:'.$info->Nmsgs, 0);
                } else {
            $message = 'Impossible de lire le contenu de la boite mail';
                    }
                }

                // foreach ($mails as $mail) {
                //     echo imap_fetchbody($mailbox,$mail->msgno,"1");
                //  }



        if (FALSE === $mails) {
                    return $message;
                } else {

                    $tableau=array(   
                        'InfoMail'=>$info,
                        'mail'=>$mails,
                        'mailbox'=>$mailbox
                    );
            return $tableau;

 
}

}


?>