package pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters.homepage;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.R;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.RepairExample;

public class RepairExamplesListAdapter  extends BaseAdapter {

    private Context context;
    private LayoutInflater inflater;
    private ArrayList<RepairExample> repairExamples;
    private Button btnDedails;

    public RepairExamplesListAdapter(Context context, ArrayList<RepairExample> repairExamples) {
        this.context = context;
        this.repairExamples = repairExamples;
    }

    @Override
    public int getCount() {
        return 0;
    }

    @Override
    public Object getItem(int i) {
        return null;
    }

    @Override
    public long getItemId(int i) {
        return 0;
    }

    @Override
    public View getView(int i, View view, ViewGroup viewGroup) {

        ViewHolderList viewHolderList = (ViewHolderList)view.getTag();
        if(viewHolderList == null){
            viewHolderList = new ViewHolderList(view);
            view.setTag(viewHolderList);
        }
        viewHolderList.update(repairExamples.get(i));

        return view;
    }

    public class ViewHolderList{

        private TextView tvBrokenScreen,tvPrice;
        private ImageView imgCapa;
        private Button btnDetails;

        public ViewHolderList(View view) {
            tvBrokenScreen = view.findViewById(R.id.tvBrokenScreen);
            //tvPrice = view.findViewById(R.id.tvPrice);
            imgCapa = view.findViewById(R.id.imgCapa);

        }

        public void update(RepairExample repairExample) {
            tvBrokenScreen.setText(repairExample.getTitle());
            //tvPrice.setText(repairExample.getPrice());
            imgCapa.setImageResource(repairExample.getImg());
        }
    }


    public static class RepairCategoryDetailAdapter extends BaseAdapter {

        private Context context;
        private LayoutInflater layoutInflater;
        private ArrayList<RepairCategoryDetailAdapter> repairCategoryDetails;

        public RepairCategoryDetailAdapter(Context context, ArrayList<RepairCategoryDetailAdapter> repairCategoryDetails) {
            this.context = context;
            this.repairCategoryDetails = repairCategoryDetails;
        }

        @Override
        public int getCount() {
            return 0;
        }

        @Override
        public Object getItem(int i) {
            return null;
        }

        @Override
        public long getItemId(int i) {
            return 0;
        }

        @Override
        public View getView(int i, View view, ViewGroup viewGroup) {

            return null;
        }

    }
}
