<!DOCTYPE html>
<html>
<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Sant Feliu Maker League</title>
    <style type="text/css">
        a {
            color: #008C95;
            text-decoration: underline;
        }
        
        body {
            font-family: helvetica, arial;
            font-size: 14px;
            text-align: center
        }
        
        .bodyMail {
            width: 600px;
            margin: 20px auto;
            text-align: left;
        }
        
        .mailContent {
            text-align: left;
            margin-bottom: 30px;
            margin-top: 30px;
        }
        
        h4 {
            font-size: 16px;
        }

        table.info td {
            border-bottom:  1px solid #eaeaea;
            padding:  10px 0;
        }
        table.info tr:last-child td{
            border-bottom:  0px solid #eaeaea;
        }
        
        @media only screen and (max-width: 630px),
        screen and (max-width: 600px) {
            table[class="responsive"] {
                width: 100% !important;
            }
            td[class="responsive"] {
                width: 100% !important;
            }
        }
    </style>

</head>

<body bgcolor="#ffffff" style="padding:0; margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:100%; background-color:#ffffff;">
    <table width="600" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#ffffff" class="body" style="width: 600px; max-width: 600px;margin: 0 auto; background-color:#ffffff;">
        <!-- HEADER -->
        <tr>
            <td valign="top" style="text-align: center; vertical-align: top; font-size: 0;">
                <table class="responsive" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="#ffffff" width="600" style="width: 100%;">
                    <tr>
                        <td bgcolor="#ffffff" valign="top" align="center" style="line-height:1px; text-align: center; padding-top: 10px; padding-bottom: 5px;">
                            <img src="<?php echo base_url('assets/img/logos/makerleague_logo.jpg');?>" width="320" style="margin: 0 auto; width:100%;text-align: center; max-width:320px;display: block;" border="0" alt="Sant Feliu Maker League" title="Sant Feliu Maker League" />
                        </td>
                    </tr>
                   
                </table>
            </td>
        </tr>        
        <!-- /HEADER -->
        <tr>
            <td width="100%">
                <table class="responsive" width="600" border="0" cellspacing="0" cellpadding="0" align="left" bgcolor="#ffffff" style="border: 2px solid #7697b4; padding: 0px 20px;">
                    <tr>
                        <td valign="top" height="15">
                            
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" valign="top" align="left" style="line-height:18px; font-size: 14px; font-family: 'Arial', sans-serif; color: #333333; padding: 0px 20px;">
                            <h1 style="text-align: center;"><?=lang('Incriure_event')?></h1> 
                            <p style="text-align: justify;"><?=lang('ok_create_eventreg')?></p>  
                            <table class="responsive" width="100%" border="0" cellspacing="0" cellpadding="0" align="left" bgcolor="#ffffff">
                                <tr>
                                    <td width="100%">
                                        <table width="100%"  class="info">                                            
                                            <tr>
                                                <td width="50%" style="text-align: left;"><b><?=lang('Name')?></b>:</td> <td width="50%" style="text-align: right;"><?php if(isset($nombre)) echo $nombre; ?></td>
                                            </tr>
                                            <tr>
                                                <td width="50%" style="text-align: left;"><b><?=lang('Surnames')?></b>:</td> <td width="50%" style="text-align: right;"><?php if(isset($apellidos)) echo $apellidos; ?></td>
                                            </tr>                                            
                                            <tr>
                                                <td width="50%" style="text-align: left;"><b><?=lang('Telephone')?></b>:</td> <td width="50%" style="text-align: right;"><?php if(isset($telefono)) echo $telefono; ?></td>
                                            </tr>
                                            <tr>
                                                <td width="50%" style="text-align: left;"><b><?=lang('Email')?></b>:</td> <td width="50%" style="text-align: right;"><?php if(isset($email)) echo $email; ?></td>
                                            </tr> 
                                            <tr>
                                                <td width="50%" style="text-align: left;"><b><?=lang('Title_event')?></b>:</td> <td width="50%" style="text-align: right;"><?php if(isset($titulo)) echo $titulo; ?></td>
                                            </tr>
                                            <tr>
                                                <td width="50%" style="text-align: left;"><b><?=lang('Horari_event')?></b>:</td> <td width="50%" style="text-align: right;"><?php if(isset($horario)) echo $horario; ?></td>
                                            </tr>
                                            <tr>
                                                <td width="50%" style="text-align: left;"><b><?=lang('Location_event')?></b>:</td> <td width="50%" style="text-align: right;"><?php if(isset($localizacion)) echo $localizacion; ?></td>
                                            </tr>                                           
                                        </table>
                                    </td>
                                </tr>
                            </table>                                                 
                        </td>                        
                    </tr>
                    <tr>
                        <td valign="top" height="15">
                            
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        
        <tr>
            <td valign="top" height="30">
                
            </td>
        </tr>
        <!-- FOOTER-->
        <tr>
            <td width="100%">
               
                <table width="100%" class="responsive top-message" cellpadding="0" cellspacing="0" border="0" align="left">
                    <tr>
                        <td width="50%" class="td-head" valign="top" height="10" align="left" style="line-height:21px; font-family:Arial, Helvetica, sans-serif; font-size:11px; color:#999999; text-align:left; padding-bottom: 20px; text-align: center;">
                            <a href="<?php echo base_url();?>" target="_blank" style="font-size: 13px; color: #7697b4; text-decoration: underline;">Sant Feliu Maker League Web</a> |                           
                            <a href="mailto:innovab@aiguesdebarcelona.cat" target="_blank" style="font-size: 13px; color: #7697b4; text-decoration: underline;">innovab@aiguesdebarcelona.cat</a>                            
                        </td>                        
                    </tr>
                </table>                
            </td>
        </tr>
        <!-- /FOOTER -->
    </table>

</body>

</html>