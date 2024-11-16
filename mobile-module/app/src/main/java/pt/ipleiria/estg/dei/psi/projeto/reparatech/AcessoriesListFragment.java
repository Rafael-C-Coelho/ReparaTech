package pt.ipleiria.estg.dei.psi.projeto.reparatech;

import android.os.Bundle;

import androidx.fragment.app.Fragment;

import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;

public class AcessoriesListFragment extends Fragment {

    public AcessoriesListFragment() {
    }

    @Override
    public View onCreateView(LayoutInflater inflater, ViewGroup container,
                             Bundle savedInstanceState) {
        // Inflate the layout for this fragment

        View view= inflater.inflate(R.layout.fragment_acessories_list, container,
                false);
       TextView tvAcessories = view.findViewById(R.id.tvAcessories);
       tvAcessories.setText("Acessórios");

//TODO: completar

        return view;
    }
}