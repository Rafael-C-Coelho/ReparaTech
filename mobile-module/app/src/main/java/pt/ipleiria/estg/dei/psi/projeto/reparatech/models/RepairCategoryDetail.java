package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;

public class RepairCategoryDetail {
    private int id, categories_list;
    private String mobile_solution, tablet_solution, desktop_laptop_solution, wearable_solution;

    public RepairCategoryDetail(int id, int categories_list, String mobile_solution, String tablet_solution, String desktop_laptop_solution, String wearable_solution) {
        this.id = id;
        this.categories_list = categories_list;
        this.mobile_solution = mobile_solution;
        this.tablet_solution = tablet_solution;
        this.desktop_laptop_solution = desktop_laptop_solution;
        this.wearable_solution = wearable_solution;
    }

    public void setId(int id) {

        this.id = id;
    }

    public int getId() {
        return id;
    }

    public String getMobile_solution() {
        return mobile_solution;
    }

    public String getTablet_solution() {
        return tablet_solution;
    }

    public String getDesktop_laptop_solution() {
        return desktop_laptop_solution;
    }

    public String getWearable_solution() {
        return wearable_solution;
    }

    public void setMobile_solution(String mobile_solution) {
        this.mobile_solution = mobile_solution;
    }

    public void setTablet_solution(String tablet_solution) {
        this.tablet_solution = tablet_solution;
    }

    public void setDesktop_laptop_solution(String desktop_laptop_solution) {
        this.desktop_laptop_solution = desktop_laptop_solution;
    }

    public void setWearable_solution(String wearable_solution) {
        this.wearable_solution = wearable_solution;
    }
}
