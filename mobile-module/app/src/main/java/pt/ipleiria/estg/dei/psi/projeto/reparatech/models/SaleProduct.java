package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;


public class SaleProduct {
    private int id;
    private int saleId;
    private int quantity;
    private double totalPrice;
    private Product product;

    public SaleProduct(int id, int saleId, int quantity, double totalPrice, Product product) {
        this.id = id;
        this.saleId = saleId;
        this.quantity = quantity;
        this.totalPrice = totalPrice;
        this.product = product;
    }

    // Getters and setters
    public int getId() { return id; }
    public void setId(int id) { this.id = id; }
    public int getSaleId() { return saleId; }
    public void setSaleId(int saleId) { this.saleId = saleId; }
    public int getQuantity() { return quantity; }
    public void setQuantity(int quantity) { this.quantity = quantity; }
    public double getTotalPrice() { return totalPrice; }
    public void setTotalPrice(double totalPrice) { this.totalPrice = totalPrice; }
    public Product getProduct() { return product; }
    public void setProduct(Product product) { this.product = product; }
}