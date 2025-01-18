package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.HomePageRepairCategory;

public class HomePageRepairCategory {
    private long id;
    private String repairCategoryName;
    private int repairCategoryImage;

    public HomePageRepairCategory(long id, String repairCategoryName, int repairCategoryImage) {
        this.id = id;
        this.repairCategoryName = repairCategoryName;
        this.repairCategoryImage = repairCategoryImage;
    }

    public long getId() {
        return id;
    }

    public String getRepairCategoryName() {
        return repairCategoryName;
    }

    public int getRepairCategoryImage() {
        return repairCategoryImage;
    }
}
