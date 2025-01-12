package pt.ipleiria.estg.dei.psi.projeto.reparatech.parsers;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.MyBooking;

public class MyBookingJsonParser {
    public static MyBooking parserJsonBooking(JSONObject response){
        try {
            int id = response.getInt("id");
            String date = response.getString("date");
            String time = response.getString("time");
            String status = response.getString("status");

            return new MyBooking(id,date,time, status);
        } catch (JSONException e){
            e.printStackTrace();
            return null;
        }
    }

    public static ArrayList<MyBooking> parserJsonBookings(JSONObject response){
        try {
            ArrayList<MyBooking> myBookings = new ArrayList<>();
            JSONArray jsonArray = response.getJSONArray("bookings");
            for (int i = 0; i < jsonArray.length(); i++){
                JSONObject myBookingCalendar = jsonArray.getJSONObject(i);
                myBookings.add(parserJsonBooking(myBookingCalendar));
            }
            return myBookings;
        } catch (JSONException e) {
            e.printStackTrace();
        }
        return null;
    }

}
