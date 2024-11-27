package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;

public class ProductCategory {
    private String name;
    private String id;

    public ProductCategory(String name, String id) {
        this.name = name;
        this.id = id;
    }

    public String getName() {
        return name;
    }

    public String getId() {
        return id;
    }
}
