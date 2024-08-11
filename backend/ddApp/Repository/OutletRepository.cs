
using ddApp.Models;
using ddApp.DAL;
using ddApp.Interfaces;
using ddApp.Models;
using System.Collections.Generic;
using System.Linq;

namespace ddApp.Repository
{
    public class OutletRepository : IOutletRepository
    {
        private readonly DataContext _context;

        public OutletRepository(DataContext context)
        {
            _context = context;
        }

        public ICollection<Outlet> GetOutlets()
        {
            return _context.Outlets.ToList();
        }

        public Outlet GetOutlet(int id)
        {
            return _context.Outlets.Find(id);
        }

        public bool OutletExists(int id)
        {
            return _context.Outlets.Any(o => o.OutletID == id);
        }

        public bool CreateOutlet(Outlet outlet)
        {
            _context.Outlets.Add(outlet);
            return Save();
        }

        public bool UpdateOutlet(Outlet outlet)
        {
            _context.Outlets.Update(outlet);
            return Save();
        }

        public bool DeleteOutlet(Outlet outlet)
        {
            _context.Outlets.Remove(outlet);
            return Save();
        }

        public bool Save()
        {
            return _context.SaveChanges() > 0;
        }
    }
}
