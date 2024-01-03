#include <WiFi.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>

const char* ssid = "Charlotte"; // SSID da sua rede Wi-Fi
const char* senha = "melhortcc";    // Senha da sua rede Wi-Fi
// const char* server = "localhost";
// const int serverPort = 3000;
// const char* apiPath = "/charlotte-app/api.js";

const int sensorPin = 13;
const int ledPin = 12;
int contador = 0;
int sensorStateAnterior = LOW;

void setup() {
  Serial.begin(115200);
  pinMode(sensorPin, INPUT);
  pinMode(ledPin, OUTPUT);

  // Conectar ao Wi-Fi
  conectarWiFi();
}

void conectarWiFi() {
  Serial.println("Conectando ao WiFi...");
  WiFi.begin(ssid, senha);
  
  int tentativas = 0;
  while (WiFi.status() != WL_CONNECTED && tentativas < 20) {
    delay(1000);
    Serial.print(".");
    tentativas++;
  }
  
  if (WiFi.status() == WL_CONNECTED) {
    Serial.println("Conectado ao WiFi");
  } else {
    Serial.println("Falha ao conectar ao WiFi. Reiniciando...");
    ESP.restart();
  }
}

void loop() {
  int sensorValue = digitalRead(sensorPin);

  if (sensorValue == HIGH && sensorStateAnterior == LOW) {
    // Incrementar o contador quando o sensor é ativado
    contador++;
    Serial.print("Contador: ");
    Serial.println(contador);

    // Criar um objeto JSON
    DynamicJsonDocument jsonDoc(200);
    jsonDoc["contador"] = contador;

    // Serializar o JSON para uma String
    String postData;
    serializeJson(jsonDoc, postData);

    // Construir a URL completa usando snprintf
    char url[100];
    snprintf(url, sizeof(url), "http://127.0.0.1:3000/charlotte-app/api.js");


    // Iniciar a conexão HTTP
    HTTPClient http;
    http.setTimeout(10000); // Timeout de 10 segundos
    http.begin(url);
    http.addHeader("Content-Type", "application/json");

    // Enviar o JSON para o servidor
    int httpResponseCode = http.POST(postData);

    if (httpResponseCode > 0) {
      String resposta = http.getString();
      Serial.println("Resposta do servidor: " + resposta);
    } else {
      Serial.println("Erro na solicitação HTTP: " + http.errorToString(httpResponseCode));
    }

    // Encerrar a conexão HTTP
    http.end();
  }

  sensorStateAnterior = sensorValue;
}