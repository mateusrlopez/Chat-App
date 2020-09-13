FROM node:12.18.0-alpine

WORKDIR /app

COPY /frontend/package.json package.json
RUN npm install --silent
RUN npm install @vue/cli@3.7.0 -g

EXPOSE 8080

CMD ["npm", "run", "serve"]