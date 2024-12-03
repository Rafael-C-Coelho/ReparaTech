package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;

import android.widget.TextView;

public class RepairCategory {

    private int id, img;
    private String title, description;


    public RepairCategory(int id, String title, String description, int img) {
        this.id = id;
        this.title = title;
        this.description = description;
        this.img = img;
    }

    public int getId() {
        return id;
    }

    public String getTitle() {
        return title;
    }

    public String getDescription() {
        return description;
    }

    public int getImg() {
        return img;
    }

    public void setTitle(String title) {
        this.title = title;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public void setImg(int img) {
        this.img = img;
    }
}
