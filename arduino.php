#include <Servo.h>

Servo gateServo; // Create a servo object
int gateAngle = 0; // Initial angle for the gate (0 degrees)

void setup() {
  gateServo.attach(9); // Attach the servo to pin 9
  gateServo.write(gateAngle); // Set initial angle
}

void loop() {
  // Your main code goes here
  // You can control the gate angle within the range of 0 to 90 
  // For example, you can increment the angle gradually in a loop
  for (gateAngle = 90; gateAngle >= 0; gateAngle--) {
    gateServo.write(gateAngle); // Move the servo to the specified angle
    delay(10); // Delay for smooth motion (adjust as needed)
  }
  delay(22000);
  // Move the gate from 0 to 90 degrees
  for (gateAngle = 0; gateAngle <= 90; gateAngle++) {
    gateServo.write(gateAngle); // Move the servo to the specified angle
    delay(10); // Delay for smooth motion (adjust as needed)
  }
  
  delay(10000); // Wait for 10 seconds

  // Move the gate from 90 to 0 degrees
  
}