package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;

public class RepairEmployee {

    private int id;
    private String clientName, progress, description, device;

    public RepairEmployee(int id, String clientName, String progress, String description, String device) {
        this.id = id;
        this.clientName = clientName;
        this.progress = progress;
        this.description = description;
        this.device = device;
    }

    public int getId() {
        return id;
    }

    public String getDevice() {
        return device;
    }

    public String getClientName() {
        return clientName;
    }

    public String getProgress() {
        return progress;
    }

    public void setClientName(String clientName) {
        this.clientName = clientName;
    }

    public void setProgress(String progress) {
        this.progress = progress;
    }

    public String getDescription() {
        return description;
    }

    public void setDescription(String description) {
        this.description = description;
    }
}
