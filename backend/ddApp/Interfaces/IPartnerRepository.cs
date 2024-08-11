using ddApp.Models;

namespace ddApp.Interfaces
{
    public interface IPartnerRepository
    {
        ICollection<Partner> GetPartners();
        Partner GetPartner(int id);
        bool PartnerExists(int id);
        bool CreatePartner(Partner partner);
        bool UpdatePartner(Partner partner);
        bool DeletePartner(Partner partner);
        bool Save();
    }
}
