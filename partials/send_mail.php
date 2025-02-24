<?php

function send_mail($emailTo, $toname, $email_copy, $camp_nome, $subject, $body, $siteLink) {
    $emailfrom = 'naoresponda@maxxpremios.com.br';
    $fromname = $camp_nome;
    $headers = 'Return-Path: ' . $emailfrom . "\r\n" .
        'From: ' . $fromname . ' <' . $emailfrom . '>' . "\r\n" .
        'Bcc: ' . $email_copy . "\r\n" .
        'X-Priority: 3' . "\r\n" .
        'X-Mailer: PHP ' . phpversion() .  "\r\n" .
        'Reply-To: ' . $fromname . ' <' . $emailfrom . '>' . "\r\n" .
        'MIME-Version: 1.0' . "\r\n" .
        'Content-Transfer-Encoding: 8bit' . "\r\n" .
        'Content-Type: text/html; charset=UTF-8' . "\r\n" .
        'Content-Encoding: UTF-8' . "\r\n\r\n";

    $params = '-f ' . $emailfrom;

    return mail($emailTo, $subject, $body, $headers, $params);
}

$emailHeader = "<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Strict//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd'>
        <html xmlns='http://www.w3.org/1999/xhtml'>
            <head>
                <meta http-equiv='content-type' content='application/xhtml+xml; charset=utf-8' />
                <meta name='mail_nameFrom' content='Maxxpremios' />
                <meta name='mail_subject' content='Seu pedido' />
                <title>Seu pedido</title>
                <style type='text/css'>body {line-height: 20px; font-size: 14px;}</style>
            </head>
            <body style='margin: 0px; '>
                <span style='visibility: hidden;height: 0;width: 0;color: #FFF;display: none;'>Seu pedido.</span>
                    <table style='word-wrap: break-word;' width='550' cellspacing='0' cellpadding='0'      border='0'      align='center'>
                        <tbody>
                            <tr>
                                <td style='text-align: center; border-top: 10px solid #3167F6; padding-top: 10px;'>
                                    <img class='banner-email' src='https://gtx100.com.br/maxx/theraskin24/img/c/logo_campanha.png' style='display:flex;border:0;margin:0 auto !important;' alt='$camp_nome' width='150' />
                                </td>
                            </tr>
                            
                            <!-- Começo Conteúdo -->
                            
                            <tr>
                                <td valign='top'>
                                    <table cellspacing='0' cellpadding='0' border='0' align='center'>
                                        <tbody>
                                            <tr>
                                                
                                                <!-- Detalhe Layout esquerdo -->
                                                
                                                <td width='42'><br /></td>
                                                
                                                <!-- Final Detalhe Layout esquerdo -->
                                                
                                                <td width='550' valign='top'>";

                                                $emailFooter = "</td>
                                                
                                            </tr>
                                                
                                            <!-- Final Total Pedido -->
                                                
                                            <tr>
                                                <td height='25'><br /></td>
                                            </tr>
                                            
                                            <!-- Informações Úteis -->
                                            
                                            <tr>
                                                <td style='font-family:Helvetica, Arial, sans-serif;font-size:12px;color:#5f479d;font-weight:bold' valign='center' bgcolor='#EEEEEE' align='center' height='24'> Informações úteis </td>
                                            </tr>
                                            <tr>
                                                <td height='10'><br /></td>
                                            </tr>
                                            <tr>
                                                <td style='font-family: Helvetica,Arial,sans-serif; font-size: 11px; color: #707070; line-height: 14px; word-spacing: 0.1em;'>
                                                <span style=''> <strong>ATENÇÃO:</strong><br />
                                                    •  A partir deste momento não é possível efetuar
                                                    alterações em seu pedido;<br />
                                                    •  O prazo de entrega passa a contar após
                                                    aprovação do pedido e não são considerados finais
                                                    de semana como dias úteis;<br />
                                                    •  O prazo de entrega do seu prêmio é de até 45
                                                    dias úteis após a sua solicitação;<br />
                                                    •  Estão autorizados a receber mercadoria
                                                    porteiros, recepcionistas, secretárias,
                                                    familiares, desde que assinem o protocolo de
                                                    entrega e apresentem documento de identificação;<br />
                                                    •  Para sua comodidade e segurança, todas as
                                                    informações inseridas em seu cadastro estão
                                                    sujeitas a confirmação.<br />
                                                </span> <br />
                                                <span> <strong><font color='#374a74'>Informações Importantes:</font></strong><br />
                                                    Informamos que para sua segurança, realizamos
                                                    análise interna das informações de seu pedido
                                                    através da validação de dados cadastrais, e este
                                                    processo pode demorar até 48 horas. Caso
                                                    necessário, poderemos entrar em contato para a
                                                    confirmação de dados, por isso, é importante que
                                                    seus dados estejam sempre completos e atualizados.<br />
                                                </span>
                                                <span><strong></strong></span> </td>
                                            </tr>
                                            
                                            <!-- Final Corpo do Email -->

                                            <tr>
                                                <td style='font-size:10px; line-height: 10px; font-family: Helvetica, Arial, sans-serif; color: #999999;'>
                                                    * Nos reservamos o direito de corrigir eventuais erros de divulgação neste e-mail e no site. Caso haja diferença nos pontos deste e-mail em relação aos do site, a pontuaçao do site é considerada o correta. <br />
                                                    Se algum prêmio não estiver disponível, você será avisado e deverá escolher outro prêmio ou prêmios no site da campanha.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height='10'><br /></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                
                <!-- Final Conteúdo --> </tr>
                
            </tbody>
        </table>
    </body>
</html>
";


function prepareOrder($name, $date, $addressHtml, $productsHtml, $total, $frete)
{
    return "
        <table width='550' cellspacing='0' cellpadding='0' border='0' align='left'>
            <tbody>
                <tr>
                    <td height='20'><br /></td>
                </tr>
                <tr>
                    <td style='font-family:Helvetica, Arial, sans-serif;font-size:13px;color:#374a74;font-weight:bold' valign='top'>
                        <span>Olá $name,</span>
                    </td>
                </tr>

                <!-- Início Corpo do Email -->

                <tr>
                    <td style='font-family:Helvetica, Arial, sans-serif;font-size:12px;color:#707070;'>
                        <span> Confira aqui as informações do seu pedido realizado em $date. </span>
                    </td>
                </tr>
                <tr>
                    <td height='25'><br /></td>
                </tr>

                <!-- Informações do seu Pedido -->

                <tr>
                    <td style='font-family:Helvetica, Arial, sans-serif;font-size:12px;color:#5f479d;font-weight:bold' valign='center' bgcolor='#EEEEEE' align='center' height='24'> 
                        Informações do seu pedido
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width='100%' cellspacing='0' cellpadding='0' border='0' align='center'> 
                            <tbody>
                                <tr>
                                    <td height='10'><br /></td>
                                </tr>
                                <tr>
                                    <td width='220' valign='top'>
                                        <table width='100%' cellspacing='0' cellpadding='0' border='0' align='left'>
                                            <tbody>
                                                <tr>
                                                    <td style='font-family:Helvetica, Arial, sans-serif;font-size:12px;color:#374a74;'>
                                                        <strong>Seu pedido será enviado para:</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style='font-family:Helvetica, Arial, sans-serif;font-size:12px;color:#707070;'>
                                                        $addressHtml
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td height='10'><br /></td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td height='10'><br />
                </td>
                </tr>

                <!-- Dados da Compra -->

                <tr>
                    <td style='font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#5f479d;font-weight:bold' valign='center' bgcolor='#EEEEEE' align='center' height='24'>
                        Dados do pedido
                    </td>
                </tr>
                <tr>
                    <td height='10'><br /></td>
                </tr>
                <tr width='415'>
                    <td>
                        <table width='100%' cellspacing='0' cellpadding='0' border='0' align='left'>
                            <tbody>
                                <tr width='415'>
                                    <td style='font-size:13px;'>
                                        <table width='100%' cellspacing='0' cellpadding='0' border='0' align='left'>
                                            <tbody>
                                                <tr width='415'>
                                                    <th width='10%'><font style='font-size:12px;color:#374a74' face='Arial, Helvetica, sans-serif'>
                                                        <strong> Cód. </strong></font><br />
                                                    </th>
                                                    <th width='1%'> <br /> </th>
                                                    <th width='68%'><font style='font-size:12px;color:#374a74' face='Arial, Helvetica, sans-serif'>
                                                        <strong> Produto </strong></font>
                                                    </th>
                                                    <th width='1%'> <br /> </th>
                                                    <th width='20%'><font style='font-size:12px;color:#374a74' face='Arial, Helvetica, sans-serif'>
                                                        <strong> Pontos </strong></font>
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <td height='5'><br /></td>
                                                </tr>
                                                $productsHtml
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>

                <!-- Final Dados da Compra -->

                <tr>
                    <td height='10'><br /></td>
                </tr>
                <tr>
                    <td height='10'><img src='https://res.cloudinary.com/maxxpremios/image/upload/f_auto,q_auto/v1526384494/i/firula_barra.jpg' style='float:left;display:block;border:0' width='550' height='1' /></td>
                </tr>

                <!-- Total Pedido -->
                
                <tr width='415'>
                    <td>
                        <table width='100%' cellspacing='0' cellpadding='0' border='0' align='left'>
                            <tbody>
                                <tr width='415'>
                                    <td width='79%' align='right'><font style='font-size:12px;color:#707070' face='Arial, Helvetica, sans-serif'>Frete:</font></td>
                                    <td width='1%'><br /></td>
                                    <td width='20%' align='center'><font style='font-size:12px;color:#5f479d' face='Arial, Helvetica, sans-serif'> $frete pontos </font></td>
                                </tr>
                                <tr width='415'>
                                    <td height='2'><br /></td>
                                </tr>
                                <tr width='415'>
                                    <td align='right'><font style='font-size:12px;color:#707070' face='Arial, Helvetica, sans-serif'><strong>Total:</strong></font></td>
                                    <td><br /></td>
                                    <td align='center'><font style='font-size:13px;color:#707070' face='Arial, Helvetica, sans-serif'><strong>
                                        $total pontos</strong></font>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        ";
}

function generateProductHtml($product) {
    $cod = $product['cod'];
    $description = $product['title'];
    $points = number_format($product['points'], 0, ',', '.');
    return "<tr width='415'>
                <td align='center' style='font-size:12px;color:#707070' >
                    $cod
                </td>
            <td>
            <br />
        </td>
        <td style='font-size:12px;color:#707070'>
            $description
        </td>
        <td><br /></td>
        <td align='center' style='font-size:12px;color:#707070'>
            $points pontos
        </td>
    </tr>";
}

// $name = 'César';

// $address = "
// Avenida Jaguaré, 818 Modulo 23 <br />
// Bairro: Jaguaré - Cidade: São Paulo - SP<br />
// CEP: 05346000
// ";

// $product = "<tr width='415'>
//   <td align='center' style='font-size:12px;color:#707070'
//       face='Arial, Helvetica, sans-serif'>
//       1567
//   </td>
//   <td>
//     <br />
//   </td>
//   <td style='font-size:12px;color:#707070'
//       face='Arial, Helvetica, sans-serif'>
//       King of Seduction Absolute Antonio
//       Banderas Eau de Toilette - Perfume
//       Masculino 50ml
//   </td>
//   <td>
//     <br />
//   </td>
//   <td align='center' style='font-size:12px;color:#707070'
//       face='Arial, Helvetica, sans-serif'> 7.399 pontos
//   </td>
// </tr>";

// $date = '01/01/1999';

// $total = "123.123";

// $mailBody = prepareOrder($name, $date, $address, $product, $total);
// $body = $header . $mailBody . $footer;

// send_mail('cesar.riello@gmail.com', $name, 'Pedido Efetuado - Maxx Prêmios', $body);
