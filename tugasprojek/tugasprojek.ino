#include <TimeLib.h>
#include<ESP8266WiFi.h>
#include<ESP8266HTTPClient.h>
#include<WiFiClient.h>

// const char* ssid = "Warmindo Remen";
// const char* password = "AA@yomi01";
// const char* serverName = "http://192.168.18.7/logging-data/sensor.php";
const char* ssid = "KLaZ";
const char* password = "senyumDulu";
const char* serverName = "http://192.168.213.9/logging-data/sensor.php";
String apiKeyValue = "123456789";

int ledmerah = 5; //D1
int ledhijau = 4; //D2
int ledkuning = 2; //D4

//ada kabel kuning dan orange
int echo1 = 14; //D5
int trigger1 = 12; //D6

//gak ada kabel kuning dan orange
int echo2 = 13; //D7
int trigger2 = 15; //D8

int durasi1;
int jarak1;

int durasi2;
int jarak2;

int timer = 5000;

time_t start_waktu;
time_t akhir_waktu;
time_t durasi;

String status;

void setup() {
  Serial.begin(115200);
  delay(10);
  WiFi.begin(ssid, password);
  while(WiFi.status() != WL_CONNECTED){
    delay(500);
    Serial.println("WIFI belum connect :)");
  }
  Serial.println("");
  Serial.print("Terhubung ke alamat : ");
  Serial.println(WiFi.localIP());
  Serial.println("----------------------------------------------");

  pinMode(ledmerah,OUTPUT);
  pinMode(ledhijau, OUTPUT);
  pinMode(ledkuning, OUTPUT);
  pinMode(echo1, INPUT);
  pinMode(trigger1, OUTPUT);
  pinMode(echo2, INPUT);
  pinMode(trigger2, OUTPUT);
}

void sensor()
{
  digitalWrite(trigger1,HIGH);
  delay(100);
  digitalWrite(trigger1,LOW);
  durasi1 = pulseIn(echo1, HIGH);
  jarak1 = (durasi1 *0.034)/2;

  delay(100);
  
  digitalWrite(trigger2,HIGH);
  delay(100);
  digitalWrite(trigger2,LOW);
  durasi2 = pulseIn(echo2, HIGH);
  jarak2 = (durasi2 *0.034)/2;

  Serial.print("jarak sensor 1 : ");
  Serial.println(jarak1);
  Serial.print("jarak sensor 2 : ");
  Serial.println(jarak2);
  Serial.print("\n");

  if(jarak1 < 15 && jarak2 < 15)
  {
    timer = 15000;
    status = "JalananPadat";
    Serial.println("Jalanan Lagi Padat (nyala hijau lebih lama)");
  }
  else{
    timer = 10000;
    status = "JalananSepi";
    Serial.println("Jalanan Lagi Sepi (nyala hijau lebih seperti biasa)");
  }


}

void loop() {

  if(WiFi.status() == WL_CONNECTED){

     //lampu merah nyala
    digitalWrite(ledhijau, LOW);
    digitalWrite(ledmerah, HIGH);
    digitalWrite(ledkuning, LOW);

    start_waktu = now(); 
    sensor();
    delay(9700);
    akhir_waktu = now();
    durasi = (akhir_waktu - start_waktu);
    Serial.println("");
    Serial.print("durasi merah : ");
    Serial.println(second(durasi));

    WiFiClient wifiClient;
    HTTPClient http;
    String address;

    address = String(serverName);
    address += "?api_key=";
    address += String(apiKeyValue);
    address += "&sensor1=";
    address += String(jarak1);
    address += "&sensor2=";
    address += String(jarak2);
    address += "&status=";
    address += String(status);

    // Serial.print("adress : ");
    // Serial.println(address);
    http.begin(wifiClient, address);
    int statusCode = http.GET();

    //lampu kuning nyala
    digitalWrite(ledkuning, HIGH);
    digitalWrite(ledhijau, LOW);
    digitalWrite(ledmerah, LOW);

    start_waktu = now(); 
    delay(2000);
    akhir_waktu = now();
    durasi = (akhir_waktu - start_waktu);
    Serial.print("durasi kuning : ");
    Serial.println(second(durasi));

    //hidupkan lampu hijau berdasarkan timer yang diset di fungsi sensor()
    digitalWrite(ledhijau, HIGH);
    digitalWrite(ledmerah, LOW);
    digitalWrite(ledkuning, LOW);

    start_waktu = now();
    delay(timer);
    akhir_waktu = now();
    durasi = (akhir_waktu - start_waktu);
    Serial.print("durasi hijau : ");
    Serial.println(second(durasi));


    //lampu kuning nyala
    digitalWrite(ledkuning, HIGH);
    digitalWrite(ledhijau, LOW);
    digitalWrite(ledmerah, LOW);

    start_waktu = now(); 
    delay(2000);
    akhir_waktu = now();
    durasi = (akhir_waktu - start_waktu);
    Serial.print("durasi kuning : ");
    Serial.println(second(durasi));

    Serial.println("\n=====================");

    
    if(statusCode > 0){
      Serial.print("HTTP Response Code : ");
      Serial.println(statusCode);
    }else{
      Serial.print("Error code : ");
      Serial.println(statusCode);
    }
    http.end();
  }else{
    Serial.println("Wifi gak connect!!!");
  }
}