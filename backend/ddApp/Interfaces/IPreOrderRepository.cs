using ddApp.Models;
using ddApp.Models;
using System.Collections.Generic;

namespace ddApp.Interfaces
{
    public interface IPreOrderRepository
    {
        ICollection<PreOrder> GetPreOrders();
        PreOrder GetPreOrder(int id);
        bool PreOrderExists(int id);
        bool CreatePreOrder(PreOrder preOrder);
        bool UpdatePreOrder(PreOrder preOrder);
        bool DeletePreOrder(PreOrder preOrder);
        bool Save();
    }
}
