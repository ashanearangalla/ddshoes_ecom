
using ddApp.Models;
using ddApp.DAL;
using ddApp.Interfaces;
using ddApp.Models;
using System.Collections.Generic;
using System.Linq;

namespace ddApp.Repository
{
    public class PreOrderRepository : IPreOrderRepository
    {
        private readonly DataContext _context;

        public PreOrderRepository(DataContext context)
        {
            _context = context;
        }

        public ICollection<PreOrder> GetPreOrders()
        {
            return _context.PreOrders.ToList();
        }

        public PreOrder GetPreOrder(int id)
        {
            return _context.PreOrders.Find(id);
        }

        public bool PreOrderExists(int id)
        {
            return _context.PreOrders.Any(po => po.PreOrderID == id);
        }

        public bool CreatePreOrder(PreOrder preOrder)
        {
            _context.PreOrders.Add(preOrder);
            return Save();
        }

        public bool UpdatePreOrder(PreOrder preOrder)
        {
            _context.PreOrders.Update(preOrder);
            return Save();
        }

        public bool DeletePreOrder(PreOrder preOrder)
        {
            _context.PreOrders.Remove(preOrder);
            return Save();
        }

        public bool Save()
        {
            return _context.SaveChanges() > 0;
        }
    }
}
