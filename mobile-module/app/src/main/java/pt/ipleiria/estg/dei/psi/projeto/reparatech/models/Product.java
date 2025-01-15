package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;

public class Product {
    private int id, stock;
    private String name;
    private double price;
    private String image;

    public Product(int id, String name,  double price, String image, int stock) {
        this.id = id;
        this.stock = stock;
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

    public String getImage() {
        return image;
    }

    public int getStock() {
        return stock;
    }

    public void setImage(String image) {
        this.image = image;
    }
}
