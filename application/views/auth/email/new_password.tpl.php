<!DOCTYPE html>
<html>
<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Aigües BCN</title>
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
                        <td bgcolor="#ffffff" valign="top"  style="line-height:1px; text-align: left; padding-top: 10px; padding-bottom: 5px;">
                            <img src="<?php echo base_url('assets/img/logoiber3d.jpg');?>" width="200" style="margin: 0 auto; width: 200px;display: block;" border="0" alt="Iber 3D" title="Iber 3D" />
                        </td>
                    </tr>
                   
                </table>
            </td>
        </tr>        
        <!-- /HEADER -->
        <tr>
            <td width="100%">
                <table class="responsive" border="0" cellspacing="0" cellpadding="0" align="left" bgcolor="#ffffff"  width="600" style="border: 2px solid #7697b4; padding: 20px;">
                    <tr>
                    	<td bgcolor="#ffffff" valign="top" align="left" style="line-height:18px; font-size: 14px; font-family: 'Arial', sans-serif; color: #666666; ">
            				<p><b><?php echo sprintf(lang('email_new_password_heading'), $identity);?></b></p>
            				<p><?php echo sprintf(lang('email_new_password_subheading'), $new_password);?></p>
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
                            <a href="<?php echo base_url();?>" target="_blank" style="font-size: 13px; color: #7697b4; text-decoration: underline;">www.iber3d.es </a> |                           
                            <a href="mailto: " target="_blank" style="font-size: 13px; color: #7697b4; text-decoration: underline;"> info@iber3d.es</a>                            
                        </td>                        
                    </tr>
                </table>                
            </td>
        </tr>
        <!-- /FOOTER -->
    </table>

</body>

</html>