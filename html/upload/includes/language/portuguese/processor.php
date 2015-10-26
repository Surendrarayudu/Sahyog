<?php
/*
Copyright © 2009-2014 Commentics Development Team [commentics.org]
License: GNU General Public License v3.0
		 http://www.commentics.org/license/

This file is part of Commentics.

Commentics is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Commentics is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Commentics. If not, see <http://www.gnu.org/licenses/>.

Text to help preserve UTF-8 file encoding: 汉语漢語.
*/

if (!isset($cmtx_path)) { die('Access Denied.'); }

/* Error box */
cmtx_define('CMTX_ERROR_NUMBER', 'Desculpe, mas %d um erro foi encontrado durante o processamento do seu comentário.');
cmtx_define('CMTX_ERRORS_NUMBER', 'Desculpe, mas %d erros foram encontrados durante o processamento do seu comentário.');
cmtx_define('CMTX_ERROR_CORRECTION', 'Por favor corrija este erro e envie o formulário de novo:');
cmtx_define('CMTX_ERRORS_CORRECTION', 'Por favor corrija estes erros e envie o formulário de novo:');

/* Preview box */
cmtx_define('CMTX_PREVIEW_TEXT', 'Apenas Visualização');

/* Approval box */
cmtx_define('CMTX_APPROVAL_OPENING', 'Obrigado.');
cmtx_define('CMTX_APPROVAL_TEXT', 'Seu comentário está aguardando aprovação.');

/* Success box */
cmtx_define('CMTX_SUCCESS_OPENING', 'Obrigado.');
cmtx_define('CMTX_SUCCESS_TEXT', 'Seu comentário foi adicionado.');

/* Error messages */
cmtx_define('CMTX_ERROR_MESSAGE_NO_NAME', 'O campo Nome não pode ser deixado vazio. Por favor, digite seu nome.');
cmtx_define('CMTX_ERROR_MESSAGE_ONE_NAME', 'Apenas um nome pode ser colocado no campo Nome. Por favor, digite apenas um nome.');
cmtx_define('CMTX_ERROR_MESSAGE_START_NAME', 'The name must start with a letter. Please start it with a letter.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_NAME', 'The name can only contain these characters: A-Z \' & . - 0-9');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_NAME', 'O nome digitado é reservado. Por favor, escolha outro nome.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_NAME', 'O nome digitado é proibido. Por favor, escolha outro nome.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_NAME', 'O nome digitado não é o seu. Por favor, digite seu nome real.');
cmtx_define('CMTX_ERROR_MESSAGE_LINK_IN_NAME', 'O nome digitado contém um link. Por favor, digite seu nome real.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_EMAIL', 'O campo Email não pode ser deixado vazio. Por favor, digite seu endereço de email.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_EMAIL', 'O endereço de email que vocë digitou aparenta ser incorreto. Por favor, cheque o que foi digitado.');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_EMAIL', 'O endereço de email digitado é reservado. Por favor, digite seu endereço de email.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_EMAIL', 'O endereço de email digitado é proibido. Por favor, digite outro endereço de email.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_EMAIL', 'O endereço de email digitado não é seu. Por favor, digite seu endereço de email.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_WEBSITE', 'O campo Website não pode ser deixado vazio. Por favor, digite seu website.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_WEBSITE', 'O endereço do website que vocë digitou aparenta ser incorreto. Por favor, cheque o que foi digitado.');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_WEBSITE', 'O endereço de website digitado é reservado. Por favor, digite seu website.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_WEBSITE', 'O website digitado é proibido. Por favor, remova-o.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_WEBSITE_IN_COMMENT', 'O website digitado em seu comentário é proibido. Por favor, remova-o.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_WEBSITE', 'O website digitado não é seu. Por favor, digite seu website.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_TOWN', 'O campo Cidade não pode ser deixado vazio. Por favor, digete sua cidade.');
cmtx_define('CMTX_ERROR_MESSAGE_START_TOWN', 'The town must start with a letter. Please start it with a letter.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_TOWN', 'The town can only contain these characters: A-Z \' & . -');
cmtx_define('CMTX_ERROR_MESSAGE_RESERVED_TOWN', 'A cidade digitada é reservada. Por favor, digite outra cidade.');
cmtx_define('CMTX_ERROR_MESSAGE_BANNED_TOWN', 'A cidade digitada é proibida. Por favor, digite outra cidade.');
cmtx_define('CMTX_ERROR_MESSAGE_DUMMY_TOWN', 'A cidade digitada não é sua, Por favor, digite sua cidade.');
cmtx_define('CMTX_ERROR_MESSAGE_LINK_IN_TOWN', 'A cidade digitada contém um link. Por favor, digite sua cidade.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_COUNTRY', 'Um País não foi selecionado. Por favor, selecione seu país.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_COUNTRY', 'O país selecionado é inválido. Por favor, tente novamente.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_RATING', 'Uma nota não foi atribuída. Por favor, atribua uma nota.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_RATING', 'A avaliação selecionado é inválido. Por favor, tente novamente.');
cmtx_define('CMTX_ERROR_MESSAGE_INVALID_REPLY', 'O comentário para o qual você está respondendo é inválido. Por favor, tente novamente.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_COMMENT', 'O campo Comentário não pode ser deixado vazio. Por favor, digite seu comentário.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_MIN', 'O comentário digitado é muito curto. Por favor, digite um comentário maior.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_MAX', 'O comentário digitado é muito longo. Por favor, diminua seu comentário.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_MAX_LINES', 'O comentário digitado tem muitas linhas. Por favor, use menos linhas.');
cmtx_define('CMTX_ERROR_MESSAGE_COMMENT_RESUBMIT', 'O comentário digitado já foi enviado. Por favor, envie um novo comentário.');
cmtx_define('CMTX_ERROR_MESSAGE_SMILIES_MAX', 'O comentário digitado possui muitos emoticons (Max: %d)');
cmtx_define('CMTX_ERROR_MESSAGE_MILD_SWEARING', 'O comentário digitado contém palavras ofensivas. Por favor, remova elas.');
cmtx_define('CMTX_ERROR_MESSAGE_STRONG_SWEARING', 'Xingamento não é permitido. Por favor, remova os palavrões do seu comentário.');
cmtx_define('CMTX_ERROR_MESSAGE_SPAMMING', 'Praticar spam não é permitido. Por favor, remova o spam do seu comentário.');
cmtx_define('CMTX_ERROR_MESSAGE_LONG_WORD', 'O comentário digitado contém uma palavra longa demais. Por favor, diminua ou remova esta palavra.');
cmtx_define('CMTX_ERROR_MESSAGE_CAPITALS', 'O comentário digital tem muitas palavras em maiúsculo. Por favor, use menos palavras em maiúsculas.');
cmtx_define('CMTX_ERROR_MESSAGE_LINK_IN_COMMENT', 'O comentário digitado contém um link. Por favor, remova o link.');
cmtx_define('CMTX_ERROR_MESSAGE_REPEATS', 'O comentário digitado contém caracteres de repetição. Por favor, remova-os.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_LINK', 'The comment contains an invalid BB Code link. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_EMAIL', 'The comment contains an invalid BB Code email. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_IMAGE', 'The comment contains an invalid BB Code image. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_BB_INVALID_VIDEO', 'The comment contains an invalid BB Code video. Please correct it.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_ANSWER', 'O campo Pergunta não pode ser deixado vazio. Por favor, digite uma resposta.');
cmtx_define('CMTX_ERROR_MESSAGE_WRONG_ANSWER', 'A resposta à pergunta não está correta. Por favor, tente novamente.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_CAPTCHA', 'O campo Captcha não pode ser deixado vazio. Por favor, digite os caracteres.');
cmtx_define('CMTX_ERROR_MESSAGE_WRONG_CAPTCHA', 'Os caracteres para a imagem do captcha estão incorretos. Por favor, tente novamente.');
cmtx_define('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_DELAY', 'Seu último comentário foi enviado recentemente. Por favor, aguarde um pouco.');
cmtx_define('CMTX_ERROR_MESSAGE_FLOOD_CONTROL_MAXIMUM', 'Você enviou vários comentários recentemente. Por favor, aguarde um pouco.');
cmtx_define('CMTX_ERROR_MESSAGE_NO_REFERRER', 'Por favor, habilite seu navegador para envio de informação de referência de origem.');
cmtx_define('CMTX_ERROR_MESSAGE_INCORRECT_REFERRER', 'The referrer suggests that you submitted from another website.');
cmtx_define('CMTX_ERROR_MESSAGE_MAXIMUMS', 'Por favor habilite seu navegador para respeitar campo comprimentos máximos.');
cmtx_define('CMTX_ERROR_MESSAGE_HONEYPOT', 'A hidden field, used to detect bots, was filled in. Please leave it empty.');
cmtx_define('CMTX_ERROR_MESSAGE_MIN_TIME', 'The form was submitted too quickly. Please take longer.');
cmtx_define('CMTX_ERROR_MESSAGE_MISSING_DATA', 'Some expected data was missing. Please submit the form again.');

/* Messages displayed to user when banned */
cmtx_define('CMTX_BAN_MESSAGE_BANNED_NEW', 'Você foi banido. isto pode ter ocorrido devido a uma varidade de motivos, incluind xingamento, prática de spam e comportamento relacionado a tentativas de invasão (hacker). Se você acredita que isto foi um erro, por favor contacte o administrador, citando seu endereço de IP.');
cmtx_define('CMTX_BAN_MESSAGE_BANNED_OLD', 'Desculpe, você foi banido anteriormente.');

/* Ban reasons */
cmtx_define('CMTX_BAN_REASON_NO_SECURITY_KEY', 'Sem chave de segurança.');
cmtx_define('CMTX_BAN_REASON_INCORRECT_SECURITY_KEY', 'Chave de segurança incorreta.');
cmtx_define('CMTX_BAN_REASON_NO_RESUBMIT_KEY', 'No resubmit key.');
cmtx_define('CMTX_BAN_REASON_INVALID_RESUBMIT_KEY', 'Invalid resubmit key.');
cmtx_define('CMTX_BAN_REASON_INJECTION', 'Tentativa de injeção.');
cmtx_define('CMTX_BAN_REASON_RESERVED_NAME', 'Nome reservado informado.');
cmtx_define('CMTX_BAN_REASON_BANNED_NAME', 'Nome banido informado.');
cmtx_define('CMTX_BAN_REASON_DUMMY_NAME', 'Nome fictício informado.');
cmtx_define('CMTX_BAN_REASON_LINK_IN_NAME', 'Link informado no nome.');
cmtx_define('CMTX_BAN_REASON_RESERVED_EMAIL', 'Endereço de email reservado informado.');
cmtx_define('CMTX_BAN_REASON_BANNED_EMAIL', 'Endereço de email banido informado.');
cmtx_define('CMTX_BAN_REASON_DUMMY_EMAIL', 'Endereço de email fictício informado.');
cmtx_define('CMTX_BAN_REASON_RESERVED_WEBSITE', 'Endereço de website reservado informado.');
cmtx_define('CMTX_BAN_REASON_BANNED_WEBSITE_IN_WEBSITE', 'Website banido informado no campo.');
cmtx_define('CMTX_BAN_REASON_BANNED_WEBSITE_IN_COMMENT', 'Website banido informado no comentário.');
cmtx_define('CMTX_BAN_REASON_DUMMY_WEBSITE', 'Website fictício informado.');
cmtx_define('CMTX_BAN_REASON_RESERVED_TOWN', 'Cidade reservada informada.');
cmtx_define('CMTX_BAN_REASON_BANNED_TOWN', 'Cidade banida informada.');
cmtx_define('CMTX_BAN_REASON_DUMMY_TOWN', 'Cidade fictícia informada.');
cmtx_define('CMTX_BAN_REASON_LINK_IN_TOWN', 'Link informado na cidade.');
cmtx_define('CMTX_BAN_REASON_MILD_SWEARING', 'Xingamento leve.');
cmtx_define('CMTX_BAN_REASON_STRONG_SWEARING', 'Xingamento pesado.');
cmtx_define('CMTX_BAN_REASON_SPAMMING', 'Prática de spam.');
cmtx_define('CMTX_BAN_REASON_CAPITALS', 'Muitas maiúsculas.');
cmtx_define('CMTX_BAN_REASON_LINK_IN_COMMENT', 'Link informado no comentário.');
cmtx_define('CMTX_BAN_REASON_REPEATS', 'Repetições informadas no comentário.');

/* Approval reasons */
cmtx_define('CMTX_APPROVE_REASON_ALL', 'Todos aprovador.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_NAME', 'Nome reservado informado.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_NAME', 'Nome banido informado.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_NAME', 'Nome fictício informado.');
cmtx_define('CMTX_APPROVE_REASON_LINK_IN_NAME', 'Link informado no nome.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_EMAIL', 'Endereço de email reservado informado.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_EMAIL', 'Endereço de email banido informado.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_EMAIL', 'Endereço de email fictício informado.');
cmtx_define('CMTX_APPROVE_REASON_WEBSITE_ENTERED', 'Website informado.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_WEBSITE', 'Website banido informado.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_WEBSITE', 'Website banido informado no campo.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_WEBSITE_IN_COMMENT', 'Banned website entered in comment.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_WEBSITE', 'Website banido informado no comentário.');
cmtx_define('CMTX_APPROVE_REASON_RESERVED_TOWN', 'Cidade reservada informada.');
cmtx_define('CMTX_APPROVE_REASON_BANNED_TOWN', 'Cidade banida informada.');
cmtx_define('CMTX_APPROVE_REASON_DUMMY_TOWN', 'Cidade fictícia informada.');
cmtx_define('CMTX_APPROVE_REASON_LINK_IN_TOWN', 'Link informado na cidade.');
cmtx_define('CMTX_APPROVE_REASON_LINK_IN_COMMENT', 'Link informado no comentário.');
cmtx_define('CMTX_APPROVE_REASON_REPEATS', 'Repetições informadas no comentário.');
cmtx_define('CMTX_APPROVE_REASON_IMAGE_ENTERED', 'Imagem informada.');
cmtx_define('CMTX_APPROVE_REASON_VIDEO_ENTERED', 'Vídeo informada.');
cmtx_define('CMTX_APPROVE_REASON_MILD_SWEARING', 'Xingamento leve.');
cmtx_define('CMTX_APPROVE_REASON_STRONG_SWEARING', 'Xingamento pesado.');
cmtx_define('CMTX_APPROVE_REASON_SPAMMING', 'Prática de spam.');
cmtx_define('CMTX_APPROVE_REASON_CAPITALS', 'Muitas maiúsculas.');
cmtx_define('CMTX_APPROVE_REASON_AKISMET', 'Akismet.');

?>