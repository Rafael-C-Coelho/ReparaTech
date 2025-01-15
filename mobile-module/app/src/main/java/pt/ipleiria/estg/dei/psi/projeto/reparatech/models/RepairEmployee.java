package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;

public class RepairEmployee {

    private int id, img;
    private String price,title;

    public RepairEmployee(int id, String title /* String price */, int img) {
        this.id = id;
        this.title = title;
        //this.price = price;
        this.img = img;
    }

    public int getId() {
        return id;
    }

    public String getTitle() {
        return title;
    }

    /*
    public String getPrice() {
        return price;
    }
     */

    public int getImg() {
        return img;
    }


    public void setTitle(String title) {
        this.title = title;
    }

    /*
    public void setPrice(String price) {
        this.price = price;
    }
    */
    public void setImg(int img) {
        this.img = img;
    }
}
