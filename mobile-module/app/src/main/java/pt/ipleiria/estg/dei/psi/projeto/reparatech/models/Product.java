package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;

public class Product {
    private int id;
    private String name;
    private double price;
    private int image;

    public Product(int id, String name,  double price, int image) {
        this.id = id;
        this.name = name;
        this.price = price;
        this.image = image;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getId() {
        return id;
    }

    public String getName() {
        return name;
    }

    public void setName(String name) {
        this.name = name;
    }

    public double getPrice() {
        return price;
    }

    public void setPrice(double price) {
        this.price = price;
    }

    public int getImage() {
        return image;
    }

    public void setImage(int image) {
        this.image = image;
    }
}
