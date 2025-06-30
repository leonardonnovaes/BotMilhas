import editacodigo_whats
import time
import os




#PUXA AS CONFIGURAÇÕES INICIAIS
bolinha_notificacao = '_ahlk'
contato_cliente = '//*[@id="main"]/header/div[2]/div/div/div/div/span' 
caixa_msg = '#main footer div.copyable-area div[contenteditable="true"]' 
msg_cliente = '_akbu'
caixa_de_pesquisa = "div[contenteditable='true'][data-tab='3']"
pega_contato = '//*[@id="main"]/header/div[2]/div/div/div/div/span'



####CARREGAR NAVEGADOR
driver = editacodigo_whats.carregar_pagina_whatsapp('zap/sessao','https://web.whatsapp.com/')

########### VARIAVEIS #######

usuario = 'leonardo@email.com'

pagina = 'http://localhost/bot/api/recebe.php?'

servidor_enviar = 'http://localhost/bot/api/enviar.php?'

servidor_confirmar = 'http://localhost/bot/api/confirma.php?'
#############################################################################

while True:
    try:
        notificacao =  editacodigo_whats.abrir_notificacao(driver,bolinha_notificacao,pega_contato,contato_cliente,msg_cliente,usuario,pagina)
        time.sleep(1)
        telefone_final = editacodigo_whats.pega_contato(driver,contato_cliente)
        time.sleep(1)
        final = editacodigo_whats.envia_as_msg_para_servidor(driver,msg_cliente,telefone_final,usuario,pagina)
    except:
        try:
            envia = editacodigo_whats.enviar_msg_do_servidor(driver, servidor_enviar,usuario,caixa_de_pesquisa,caixa_msg,servidor_confirmar)
            print(envia)
        except Exception as e:
            print("Erro no envio:", str(e))
        
       