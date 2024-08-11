using ddApp.Models;
using ddApp.Models;
using System.Collections.Generic;

namespace ddApp.Interfaces
{
    public interface IOutletRepository
    {
        ICollection<Outlet> GetOutlets();
        Outlet GetOutlet(int id);
        bool OutletExists(int id);
        bool CreateOutlet(Outlet outlet);
        bool UpdateOutlet(Outlet outlet);
        bool DeleteOutlet(Outlet outlet);
        bool Save();


    }
}
