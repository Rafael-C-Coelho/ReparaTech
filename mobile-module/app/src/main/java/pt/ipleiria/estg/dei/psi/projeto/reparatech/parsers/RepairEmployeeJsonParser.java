package pt.ipleiria.estg.dei.psi.projeto.reparatech.parsers;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Comment;

public class RepairEmployeeJsonParser {
    public static ArrayList<Comment> parseComments(JSONArray response) {
        ArrayList<Comment> comments = new ArrayList<>();
        try {
            for (int i = 0; i < response.length(); i++) {
                JSONObject comment = response.getJSONObject(i);
                int id = comment.getInt("id");
                String description = comment.getString("description");
                String date = comment.getString("date");
                String time = comment.getString("time");
                int idRepair = comment.getInt("repair_id");
                comments.add(new Comment(id, description, date, time, idRepair));
            }
        } catch (JSONException e) {
            e.printStackTrace();
        }
        return comments;
    }
}
