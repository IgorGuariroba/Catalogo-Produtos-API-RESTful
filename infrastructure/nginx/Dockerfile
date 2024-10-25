# Dockerfile para webserver

# Utiliza a imagem base do Nginx no Alpine, por ser uma versão leve
FROM nginx:alpine

# Define o diretório de trabalho dentro do container
WORKDIR /etc/nginx

# Copia o arquivo de configuração personalizado do Nginx para dentro do container
COPY infrastructure/nginx/default.conf /etc/nginx/conf.d/default.conf

# Cria o diretório necessário para cache e ajusta permissões
RUN mkdir -p /var/cache/nginx/client_temp && \
    mkdir -p /var/run/nginx && \
    chown -R nginx:nginx /var/cache/nginx && \
    chown -R nginx:nginx /var/run/nginx

# Expõe a porta 80 para servir a aplicação
EXPOSE 80

# Comando padrão para iniciar o Nginx
CMD ["nginx", "-g", "daemon off;"]
