import { TGoods, TTypeGoods } from "../../../type";
import { ListGoods } from "../list-goods/ListGoods";

interface IGetComponentByTypeGoods {
  typeGoods: TTypeGoods;
  goods: TGoods[];
}
export const GetComponentByTypeGoods = ({
  goods,
  typeGoods,
}: IGetComponentByTypeGoods) => {
  if (typeGoods === null) return null;
  if (!typeGoods === null && goods.length === 0)
    return <div>Упс, по вашему запросу ничего не найдено</div>;
  return <ListGoods goods={goods} />;
};
