import { PageInfoContextComponent } from "./contexts/PageInfoContext";
import { Goods } from "./pages/goods/Googs";

function App() {
  return (
    <PageInfoContextComponent>
      <Goods />
    </PageInfoContextComponent>
  );
}

export default App;
