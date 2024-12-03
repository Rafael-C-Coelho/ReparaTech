package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;

import java.sql.SQLOutput;
import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.R;

public class ReparaTechSingleton {

    private ArrayList<RepairExample> repairExamples;
    private ArrayList<BestSellingProduct> bestSellingProducts;
    private ArrayList<RepairCategory> repairCategories;
    private static ReparaTechSingleton instance = null;


    private ReparaTechSingleton(){
        generateDinamicRepairExamples();
        generateDinamicBestSellingProducts();
        generateDinamicRepairCategories();
    }

    public static synchronized ReparaTechSingleton getInstance() {
        if(instance==null) {
            instance = new ReparaTechSingleton();
        }
        return instance;
    }

    private void generateDinamicRepairExamples(){
        repairExamples = new ArrayList<>();
        //repairExamples.add(new RepairExample(1,"AUDIO PROBLEMS" /*"FROM 30€"*/, R.drawable.audio_issues));
        repairExamples.add(new RepairExample(2,"BROKEN SCREEN" /*"FROM 50€"*/, R.drawable.broked_screen));
        //repairExamples.add(new RepairExample(3,"CONNECTIVITY ISSUES" /* "FROM 40€" */, R.drawable.iphone_capa));
        //repairExamples.add(new RepairExample(4,"LIQUID DAMAGE" /*"FROM 70€"*/, R.drawable.iphone_capa));
        repairExamples.add(new RepairExample(5,"CAMERA ISSUES" /*"FROM 40€"*/, R.drawable.iphone_capa));
        repairExamples.add(new RepairExample(6,"STORAGE DAMAGE" /*"FROM 50€"*/, R.drawable.storage_issues));
        //repairExamples.add(new RepairExample(7,"DAMAGE BUTTONS" /*"FROM 25€"*/, R.drawable.buttons_iphone));
        repairExamples.add(new RepairExample(8,"BATTERY ISSUES" /*"FROM 40€"*/, R.drawable.battery_issues));
        repairExamples.add(new RepairExample(9,"NETWORK ISSUES" /*"FROM 50€"*/, R.drawable.network_issues));
        /*repairExamples.add(new RepairExample(10,"DATA RECOVERY | BACKUP", "FROM 60€", R.drawable.iphone_capa));
        repairExamples.add(new RepairExample(11,"SOFTWARE PROBLEMS", "FROM 30€", R.drawable.software_issues));
        repairExamples.add(new RepairExample(12,"INTERNAL HARDWARE CLEANING | MAINTENANCE", "FROM 20€", R.drawable.cleaning_computer)); */
        repairExamples.add(new RepairExample(13,"VIEW ALL",R.drawable.repairs));



    }

    private void generateDinamicBestSellingProducts() {
        bestSellingProducts = new ArrayList<>();
        bestSellingProducts.add(new BestSellingProduct(1,"Capa Iphone",20, R.drawable.iphone_capa));
        bestSellingProducts.add(new BestSellingProduct(2,"Cabo USB-C",10, R.drawable.iphone_capa));
        bestSellingProducts.add(new BestSellingProduct(3,"Película de Ecrã Iphone 13",12, R.drawable.iphone_capa));
        bestSellingProducts.add(new BestSellingProduct(4,"Película de Ecrã Xiaomi Redmi Note 13",12, R.drawable.iphone_capa));
        bestSellingProducts.add(new BestSellingProduct(5,"Mochila ASUS para Laptop ",55, R.drawable.iphone_capa));
        bestSellingProducts.add(new BestSellingProduct(6,"Rato Ergonómico Logitech",85, R.drawable.iphone_capa));
    }

    private void generateDinamicRepairCategories(){
        repairCategories = new ArrayList<>();
        repairCategories.add(new RepairCategory(1,"Camera Issues",
                "If your device has camera damaged, our team is ready to solve the problem with maximum efficiency and quality.",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategory(2,"Broken Screen",
                "If your device has camera damaged, our team is ready to solve the problem with maximum efficiency and quality.",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategory(3,"Camera Issues",
                "If your device has camera damaged, our team is ready to solve the problem with maximum efficiency and quality.",
                R.drawable.iphone_capa));
        repairCategories.add(new RepairCategory(4,"Broken Screen",
                "If your device has camera damaged, our team is ready to solve the problem with maximum efficiency and quality.",
                R.drawable.iphone_capa));

        System.out.println("Repair Categories generated: " + repairCategories.size());
    }



    public ArrayList<RepairExample> getRepairExamples(){

        return new ArrayList<>(repairExamples);
    }

    public ArrayList<BestSellingProduct> getbestSellingProductsExamples() {
        return new ArrayList<>(bestSellingProducts);
    }

    public ArrayList<RepairCategory> getRepairCategories(){
        return new ArrayList<>(repairCategories);
    }


}
