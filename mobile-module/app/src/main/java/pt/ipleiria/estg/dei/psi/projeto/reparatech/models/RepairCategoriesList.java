package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;

public class RepairCategoriesList {

    private int id, img;
    private String title, description;


    public RepairCategoriesList(int id, String title, String description, int img) {
        this.id = id;
        this.title = title;
        this.description = description;
        this.img = img;
    }

    public void setId(int id) {
        this.id = id;
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
