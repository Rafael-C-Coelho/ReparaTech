package pt.ipleiria.estg.dei.psi.projeto.reparatech.utils;


import android.annotation.SuppressLint;
import android.app.Activity;
import android.content.Context;
import android.os.Build;
import android.os.Looper;
import android.util.Base64;
import android.widget.Toast;

import org.eclipse.paho.android.service.MqttAndroidClient;
import org.eclipse.paho.client.mqttv3.DisconnectedBufferOptions;
import org.eclipse.paho.client.mqttv3.IMqttActionListener;
import org.eclipse.paho.client.mqttv3.IMqttDeliveryToken;
import org.eclipse.paho.client.mqttv3.IMqttMessageListener;
import org.eclipse.paho.client.mqttv3.IMqttToken;
import org.eclipse.paho.client.mqttv3.MqttCallback;
import org.eclipse.paho.client.mqttv3.MqttCallbackExtended;
import org.eclipse.paho.client.mqttv3.MqttClient;
import org.eclipse.paho.client.mqttv3.MqttConnectOptions;
import org.eclipse.paho.client.mqttv3.MqttException;
import org.eclipse.paho.client.mqttv3.MqttMessage;
import org.json.JSONException;
import org.json.JSONObject;

import java.security.MessageDigest;
import java.security.NoSuchAlgorithmException;
import java.util.logging.Handler;
import java.util.logging.LogRecord;


public class MqttManager implements MqttCallback{
    MqttClient mqttClient;;
    private Context context = null;
    private NotificationHelper notificationHelper;


    public static String md5Base64(String input) {
        try {
            // Step 1: Base64 encode the input string
            String base64Encoded = Base64.encodeToString(input.getBytes(), Base64.NO_WRAP);

            // Step 2: Create MD5 hash
            MessageDigest digest = MessageDigest.getInstance("MD5");
            byte[] md5Bytes = digest.digest(base64Encoded.getBytes());

            // Step 3: Convert MD5 bytes to hexadecimal string
            StringBuilder hexString = new StringBuilder();
            for (byte b : md5Bytes) {
                String hex = Integer.toHexString(0xFF & b);
                if (hex.length() == 1) {
                    hexString.append('0'); // Pad with leading zero if needed
                }
                hexString.append(hex);
            }

            return hexString.toString();
        } catch (NoSuchAlgorithmException e) {
            e.printStackTrace();
        }

        return null; // Return null in case of an error
    }


    public MqttManager(Context context, String host, String email) {
        this.context = context;
        String clientId = MqttClient.generateClientId();
        try {
            mqttClient = new MqttClient(host, clientId, null);
        } catch (MqttException e) {
            throw new RuntimeException(e);
        }

        try {
            mqttClient = new MqttClient(host, clientId, null);
            MqttConnectOptions mqttConnectOptions = new MqttConnectOptions();
            mqttConnectOptions.setAutomaticReconnect(true);
            mqttConnectOptions.setCleanSession(true);

            mqttClient.connect(mqttConnectOptions);
            Toast.makeText(context, "Successfully connected to the broker", Toast.LENGTH_SHORT).show();

            mqttClient.setCallback(this);
            this.notificationHelper = new NotificationHelper(context, this.getClass());
            subscribeToTopic("reparatech/client_" + md5Base64(email));
        } catch (MqttException ex) {
            ex.printStackTrace();
        }
    }


    public void subscribeToTopic( String topic) {
        try {
            mqttClient.subscribe(topic, 0);
            System.out.println("subscribe mqtt");
        } catch (MqttException e) {
            e.printStackTrace();
        }
    }

    @Override
    public void connectionLost(Throwable cause) {
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.P) {
            context.getMainExecutor().execute(() -> // executado de forma assíncrona no thread principal
                    Toast.makeText(context, "Connection Lost", Toast.LENGTH_SHORT).show()
            );
        }
    }

    public void messageArrived(String topic, MqttMessage message) throws Exception {
        String messageContent = new String(message.getPayload());
        JSONObject messageObj = new JSONObject(messageContent);
        // Show notification instead of Toast
        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.P) {
            context.getMainExecutor().execute(() ->
                    {
                        try {
                            notificationHelper.showNotification(
                                    "ReparaTech Message",
                                    messageObj.getString("description")
                            );
                        } catch (JSONException e) {
                            throw new RuntimeException(e);
                        }
                    }
            );
        }
    }

    @Override
    public void deliveryComplete(IMqttDeliveryToken token) {

    }
}