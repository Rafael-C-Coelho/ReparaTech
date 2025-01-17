package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;

import java.util.ArrayList;

public class RepairEmployee {
    private int id;
    private String device;
    private String description;
    private String progress;
    private String clientName;
    private ArrayList<Comment> comments;

    public RepairEmployee(int id, String device, String description, String progress, String clientName) {
        this.id = id;
        this.device = device;
        this.description = description;
        this.progress = progress;
        this.clientName = clientName;
        this.comments = new ArrayList<>();
    }

    // Getters
    public int getId() { return id; }
    public String getDevice() { return device; }
    public String getDescription() { return description; }
    public String getProgress() { return progress; }
    public String getClientName() { return clientName; }
    public ArrayList<Comment> getComments() { return comments; }

    // Setters
    public void setComments(ArrayList<Comment> comments) {
        this.comments = comments;
    }
    public void setProgress(String progress) {
        this.progress = progress;
    }
}