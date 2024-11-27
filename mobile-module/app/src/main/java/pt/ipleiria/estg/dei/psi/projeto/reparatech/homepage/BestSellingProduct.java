package pt.ipleiria.estg.dei.psi.projeto.reparatech.homepage;

import android.widget.TextView;

public class BestSellingProduct {

    private int id, img, price;
    private String title;

    public BestSellingProduct(int id, String title, int price, int img) {
        this.id = id;
        this.title = title;
        this.price = price;
        this.img = img;
    }

    public int getId() {
        return id;
    }

    public String getTitle() {
        return title;
    }

    public int getPrice() {
        return price;
    }

    public int getImg() {
        return img;
    }

    public void setTitle(String title) {
        this.title = title;
    }

    public void setPrice(int price) {
        this.price = price;
    }

    public void setImg(int img) {
        this.img = img;
    }
}
