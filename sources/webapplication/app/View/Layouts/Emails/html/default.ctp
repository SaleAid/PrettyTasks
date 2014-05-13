<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
   "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <title><?php  echo $title_for_layout;  ?></title>
    <style type="text/css">

        .ReadMsgBody { width: 100%; background-color: #eeeeee;}
        .ExternalClass {width: 100%; background-color: #eeeeee;}
        .ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height:100%;}
        body {-webkit-text-size-adjust:none; -ms-text-size-adjust:none;}
        body {margin:0; padding:0;}
        table {border-spacing:0;}
        table td {border-collapse:collapse;}
        .yshortcuts a {border-bottom: none !important;}
        td[class="td-header"] {
            padding-top: 0px !important;
        }

        @media screen and (max-width: 600px) {
            table[class="container"] {
                width: 95% !important;
            }
        }
        @media screen and (max-width: 480px) {
            td[class="container-padding"] {
                padding-left: 12px !important;
                padding-right: 12px !important;
            }
         }
    </style>
</head>
<body style="margin:0; padding:10px 0;" bgcolor="#f5f5f5" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" bgcolor="#f5f5f5">
  <tr>
    <td class="td-header" align="center" valign="top" width="100%" height="20px"  bgcolor="#f5f5f5" style="background-color: #f5f5f5;"></td>
  </tr>
  <tr>
    <td align="center" valign="top" bgcolor="#f5f5f5" style="background-color: #f5f5f5;">
      <table border="0" width="600" cellpadding="0" cellspacing="0" class="container" bgcolor="#ffffff" style="border: 1px #bce8f1 solid; ">
        <tr>
          <td class="container-padding" bgcolor="#ffffff" style="background-color: #ffffff; padding-left: 30px; padding-right: 30px; font-size: 14px; line-height: 20px; font-family: Helvetica, sans-serif; color: #222244 !important;">
            <br>
            <?php echo $content_for_layout; ?>
            <br/>
            <hr style = "background-color:#cccccc; border-width:0; color:#cccccc; height:1px; lineheight:0; display: inline-block; text-align: left; width:75%;" />
            <p style="font-style:italic; font-size: 12px; color: #aaaaaa; margin-top:0px; padding-top:0px;">
<?php
if(Configure::read('Config.language') =='eng'):
?>
Best regards, <?php echo Configure::read('Site.name'); ?> team<br/>
If you have any questions, please contact us prettytasks@gmail.com
<?php else: ?>
С уважением, команда <?php echo Configure::read('Site.name'); ?><br/>
По любым вопросам обращайтесь по адресу prettytasks@gmail.com    
<?php endif;?>
            </p>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td class="td-header" align="center" valign="top" width="100%" height="20px" bgcolor="#f5f5f5" style="background-color: #f5f5f5;">
    &nbsp;
    </td>
  </tr>
</table>
<br>
</body>
</html>

