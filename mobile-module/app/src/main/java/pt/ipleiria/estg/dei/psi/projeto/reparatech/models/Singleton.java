package pt.ipleiria.estg.dei.psi.projeto.reparatech.models;

public class Singleton {

    private static Singleton instance = null;
    private Settings settings;

    private Singleton(Settings settings) {
        this.settings = settings;
        carregarDadosDinamicos();
    }

    public static synchronized Singleton getInstance(Settings settings) {
        if (instance == null)
            instance = new Singleton(settings);
        return instance;
    }

    private void carregarDadosDinamicos() {
        // Load dynamic data, potentially using settings
    }

    public Settings getSettings() {
        return settings;
    }
}
