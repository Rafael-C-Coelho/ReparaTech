package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;

import java.time.LocalDate;
import java.time.LocalTime;

public class EmployeeRepair {
    private int id;
    private String progress;
    private String clientName;


    public EmployeeRepair(int id, String progress, String clientName) {
        this.id = id;
    }

    public int getId() {
        return id;
    }


}
