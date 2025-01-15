package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;

public class Comment {
    private int id, idRepair;
    private String description, time, date;

    public Comment(int id, String description, String date, String time, int idRepair) {
        this.id = id;
        this.description = description;
        this.date = date;
        this.time = time;
        this.idRepair = idRepair;
    }

    public int getId() {
        return id;
    }

    public String getDescription() {
        return description;
    }

    public String getDate() {
        return date;
    }

    public String getTime() {
        return time;
    }

    public int getIdRepair() {
        return idRepair;
    }
}
