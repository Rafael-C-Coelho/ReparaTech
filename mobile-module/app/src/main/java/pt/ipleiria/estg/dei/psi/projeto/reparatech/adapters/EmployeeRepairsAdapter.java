package pt.ipleiria.estg.dei.psi.projeto.reparatech.adapters;

import android.content.Context;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;

import com.bumptech.glide.Glide;
import com.bumptech.glide.load.engine.DiskCacheStrategy;

import java.util.ArrayList;

import pt.ipleiria.estg.dei.psi.projeto.reparatech.R;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.CartItem;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.Product;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.RepairEmployee;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechDBHelper;
import pt.ipleiria.estg.dei.psi.projeto.reparatech.models.ReparaTechSingleton;

public class EmployeeRepairsAdapter extends BaseAdapter
{
    private Context context;
    private ArrayList<RepairEmployee> repairs;
    private LayoutInflater inflater;

    public EmployeeRepairsAdapter(Context context, ArrayList<RepairEmployee> repairs)
    {
        this.context = context;
        this.repairs = repairs;
    }

    @Override
    public int getCount() {
        return repairs.size();
    }

    @Override
    public Object getItem(int i) {
        return repairs.get(i);
    }

    @Override
    public long getItemId(int i) {
        return repairs.get(i).getId();
    }


    @Override
    public View getView(int i, View convertView, ViewGroup parent) {
        if (inflater == null) {
            inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
        }

        if (convertView == null) {
            convertView = inflater.inflate(R.layout.item_repair_employee, null);
        }

        ViewHolderList viewHolderList = (ViewHolderList) convertView.getTag();
        if (viewHolderList == null) {
            viewHolderList = new ViewHolderList(convertView);
            convertView.setTag(viewHolderList);
        }
        viewHolderList.update(repairs.get(i));

        return convertView;
    }

    public void updateItem(int position, RepairEmployee updatedItem) {
        if (position >= 0 && position < repairs.size()) {
            repairs.set(position, updatedItem);
            notifyDataSetChanged();
        }
    }

    private class ViewHolderList {
        private TextView tvId, tvProgress, tvClientName, tvDescription;

        public ViewHolderList(View view) {
            tvId = view.findViewById(R.id.tvId);
            tvProgress = view.findViewById(R.id.tvStatus);
            tvClientName = view.findViewById(R.id.tvClientName);
            tvDescription = view.findViewById(R.id.tvDescription);
        }

        private int getPositionById(int id) {
            for (int i = 0; i < repairs.size(); i++) {
                if (repairs.get(i).getId() == id) {
                    return i;
                }
            }
            return -1;
        }

        public void update(RepairEmployee repair) {
            ReparaTechDBHelper dbHelper = new ReparaTechDBHelper(context);
            tvId.setText(String.valueOf(repair.getId()));
            tvProgress.setText(repair.getProgress());
            tvClientName.setText(repair.getClientName());
            tvDescription.setText(repair.getDescription());
        }
    }
}
