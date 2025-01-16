package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;

import java.sql.Timestamp;
import java.util.List;

public class Order {
    private int id;
    private String status;
    private double totalOrder;
    private String totalProducts;
    private int productQuantity;
    private List<Product> products;

    public Order(int id, String status, double totalOrder, String totalProducts, int productQuantity, List<Product> products) {
        this.id = id;
        this.status = status;
        this.totalOrder = totalOrder;
        this.totalProducts = totalProducts;
        this.productQuantity = productQuantity;
        this.products = products;
    }

    public int getId() {
        return id;
    }

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

    public double getTotalOrder() {
        return totalOrder;
    }

    public void setTotalOrder(double totalOrder) {
        this.totalOrder = totalOrder;
    }

    public String getTotalProducts() {
        return totalProducts;
    }

    public void setTotalProducts(String totalProducts) {
        this.totalProducts = totalProducts;
    }

    public int getProductQuantity() {
        return productQuantity;
    }

    public void setProductQuantity(int productQuantity) {
        this.productQuantity = productQuantity;
    }

    public List<Product> getProducts() {
        return products;
    }

    public void setProducts(List<Product> products) {
        this.products = products;
    }
}
