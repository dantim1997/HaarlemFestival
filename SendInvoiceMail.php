<?php
    require_once( "Autoloader.php");
    require_once( "CreateInvoicePDF.php");
class SendInvoiceMail{
    public function SendCustomerMail($customerInfo, $tickets)
    {
        // email stuff (change data below)
        $to = $customerInfo[5]; 
        $from = "NOREPLY@HaarlemFestival.nl"; 
        $subject = "Your Invoice of Haarlem Festival"; 
        $message = "<p>Thank you for purchesing the tickets.</p>";
        
        // a random hash will be necessary to send mixed content
        $separator = md5(time());
        
        // carriage return type (we use a PHP end of line constant)
        $eol = PHP_EOL;
        
        // attachment name
        $filename = "Invoice_Haarlem_Festival.pdf";
        
        // encode data (puts attachment in proper format)
        
        $PDF = new PDFInvoiceMaker;
        $pdfdoc = $PDF->MakePDF($customerInfo, $tickets);
        $attachment = chunk_split(base64_encode($pdfdoc));
        
        // main header
        $headers  = "From: ".$from.$eol;
        $headers .= "MIME-Version: 1.0".$eol; 
        $headers .= "Content-Type: multipart/mixed; boundary=\"".$separator."\"";
        
        // no more headers after this, we start the body! //
        
        // message
        $body = "";
        $body .= "Content-Type: text/html; charset=\"iso-8859-1\"".$eol;
        $body .= "Content-Transfer-Encoding: 8bit".$eol.$eol;
        $body .= $message.$eol;
        
        // attachment
        $body .= "--".$separator.$eol;
        $body .= "Content-Type: application/octet-stream; name=\"".$filename."\"".$eol; 
        $body .= "Content-Transfer-Encoding: base64".$eol;
        $body .= "Content-Disposition: attachment".$eol.$eol;
        $body .= $attachment.$eol;
        $body .= "--".$separator."--";
        
        // send message
        mail($to, $subject, $body, $headers);
        
    }
    }
    ?>