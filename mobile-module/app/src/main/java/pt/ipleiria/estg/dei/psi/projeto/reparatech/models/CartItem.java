package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;

public class CartItem {
    private int id;
    private int idProduct;
    private int quantity;

    public CartItem(int id, int idProduct, int quantity) {
        this.id = id;
        this.idProduct = idProduct;
        this.quantity = quantity;
    }

    public int getId() {
        return id;
    }

    public int getIdProduct() {
        return idProduct;
    }

    public int getQuantity() {
        return quantity;
    }
}
