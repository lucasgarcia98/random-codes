            /* ***********************
            FUNÇÃO PARA PEGAR O TOKEN
            *********************** */
            $auth = base64_encode('autenticacao');
            // Iniciando cUrl
            $chToken = curl_init();

            // Adicionando a url do token na função setopt (url)
            curl_setopt($chToken, CURLOPT_URL, 'http://endpoint/token');

            // Permitindo retorno das informações buscadas
            curl_setopt($chToken, CURLOPT_RETURNTRANSFER, true);

            // Personalizando o Header da Requisição
            // Adicionando o Authorization com a informação de autenticação codificada em base64, e declarando o Content-Type para o modelo de informação na url. Estilo GET
            curl_setopt($chToken, CURLOPT_HTTPHEADER, array(
                'Authorization: Basic ' . $auth,
                'Content-Type: application/x-www-form-urlencoded'
            ));

            // Indicando que vai conter informação no POST
            curl_setopt($chToken, CURLOPT_POST, true);

            // Enviando as informações via POST, nesse caso vai ser convertido para modelo na URL.
            // Ficando dessa maneira: grant_type=password&username=username&password=password
            curl_setopt(
                $chToken,
                CURLOPT_POSTFIELDS,
                http_build_query(array(
                    'grant_type' => 'password',
                    'username' => $clientAuth,
                    'password' => $clientPass
                ))
            );

            // Executando a cUrl e após isso decodificando do formato JSON para leitura.
            $token = json_decode(curl_exec($chToken));

            // Populando variável Token com o Token retornado da cUrl.
            $token = $token->access_token;
            
            // Fechando a chamada do Token
            curl_close($chToken);
