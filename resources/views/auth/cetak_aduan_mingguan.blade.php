<?php

    $w = "<?xml version=\"1.0\"?>
            <?mso-application progid=\"Excel.Sheet\"?>
            <Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\"
            xmlns:o=\"urn:schemas-microsoft-com:office:office\"
            xmlns:x=\"urn:schemas-microsoft-com:office:excel\"
            xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\"
            xmlns:html=\"http://www.w3.org/TR/REC-html40\">
            <DocumentProperties xmlns=\"urn:schemas-microsoft-com:office:office\">
            <Author>Ahmad Thor</Author>
            <LastAuthor>Ahmad Thor</LastAuthor>
            <Created>2021-07-26T15:49:27Z</Created>
            <LastSaved>2021-07-26T16:08:04Z</LastSaved>
            <Version>16.00</Version>
            </DocumentProperties>
            <OfficeDocumentSettings xmlns=\"urn:schemas-microsoft-com:office:office\">
            <AllowPNG/>
            </OfficeDocumentSettings>
            <ExcelWorkbook xmlns=\"urn:schemas-microsoft-com:office:excel\">
            <WindowHeight>12225</WindowHeight>
            <WindowWidth>28800</WindowWidth>
            <WindowTopX>32767</WindowTopX>
            <WindowTopY>32767</WindowTopY>
            <ActiveSheet>1</ActiveSheet>
            <ProtectStructure>False</ProtectStructure>
            <ProtectWindows>False</ProtectWindows>
            </ExcelWorkbook>
            <Styles>
            <Style ss:ID=\"Default\" ss:Name=\"Normal\">
            <Alignment ss:Vertical=\"Bottom\"/>
            <Borders/>
            <Font ss:FontName=\"Calibri\" x:Family=\"Swiss\" ss:Size=\"11\" ss:Color=\"#000000\"/>
            <Interior/>
            <NumberFormat/>
            <Protection/>
            </Style>
            <Style ss:ID=\"s65\">
            <Borders>
                <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
                <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
                <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
                <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
            </Borders>
            </Style>
            <Style ss:ID=\"s66\">
            <Alignment ss:Horizontal=\"Center\" ss:Vertical=\"Center\"/>
            <Borders>
                <Border ss:Position=\"Bottom\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
                <Border ss:Position=\"Left\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
                <Border ss:Position=\"Right\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
                <Border ss:Position=\"Top\" ss:LineStyle=\"Continuous\" ss:Weight=\"1\"/>
            </Borders>
            <Font ss:FontName=\"Calibri\" x:Family=\"Swiss\" ss:Size=\"11\" ss:Color=\"#000000\"
                ss:Bold=\"1\"/>
            </Style>
            </Styles>
            <Worksheet ss:Name=\"per Kategori\">
            <Table ss:ExpandedColumnCount=\"3000000\" ss:ExpandedRowCount=\"2000000\" x:FullColumns=\"1\"
            x:FullRows=\"1\" ss:DefaultRowHeight=\"15\">
            <Column ss:AutoFitWidth=\"0\" ss:Width=\"44.25\"/>
            <Column ss:AutoFitWidth=\"0\" ss:Width=\"206.25\"/>
            <Column ss:AutoFitWidth=\"0\" ss:Width=\"85.5\"/>
            <Row ss:AutoFitHeight=\"0\" ss:Height=\"21.75\">
                <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">No</Data></Cell>
                <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">Jenis Aduan</Data></Cell>
                <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">Jumlah Laporan</Data></Cell>
            </Row>";
            $n = 0;
            foreach($kategoris as $kategori) {
                $n++;
                $w.="<Row ss:AutoFitHeight=\"0\" ss:Height=\"21.75\">
                    <Cell ss:StyleID=\"s65\"><Data ss:Type=\"Number\">".$n."</Data></Cell>
                    <Cell ss:StyleID=\"s65\"><Data ss:Type=\"String\">".$kategori->jenis_aduan."</Data></Cell>
                    <Cell ss:StyleID=\"s65\"><Data ss:Type=\"Number\">".$kategori->jumlah_laporan."</Data></Cell>
                </Row>";
            }
            $w.="</Table>
            <WorksheetOptions xmlns=\"urn:schemas-microsoft-com:office:excel\">
            <PageSetup>
                <Header x:Margin=\"0.3\"/>
                <Footer x:Margin=\"0.3\"/>
                <PageMargins x:Bottom=\"0.75\" x:Left=\"0.7\" x:Right=\"0.7\" x:Top=\"0.75\"/>
            </PageSetup>
            <Print>
                <ValidPrinterInfo/>
                <PaperSizeIndex>9</PaperSizeIndex>
                <VerticalResolution>0</VerticalResolution>
            </Print>
            <Panes>
                <Pane>
                <Number>3</Number>
                <RangeSelection>R1C1:R1C3</RangeSelection>
                </Pane>
            </Panes>
            <ProtectObjects>False</ProtectObjects>
            <ProtectScenarios>False</ProtectScenarios>
            </WorksheetOptions>
            </Worksheet>
            <Worksheet ss:Name=\"per KabKota\">
            <Table ss:ExpandedColumnCount=\"4000000\" ss:ExpandedRowCount=\"2000000\" x:FullColumns=\"1\"
            x:FullRows=\"1\" ss:DefaultRowHeight=\"15\">
            <Column ss:Index=\"2\" ss:AutoFitWidth=\"0\" ss:Width=\"138.75\"/>
            <Column ss:AutoFitWidth=\"0\" ss:Width=\"135\"/>
            <Column ss:AutoFitWidth=\"0\" ss:Width=\"162\"/>
            <Row ss:AutoFitHeight=\"0\" ss:Height=\"25.5\">
                <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">No</Data></Cell>
                <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">Kab/Kota</Data></Cell>
                <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">Jumlah Laporan</Data></Cell>
                <Cell ss:StyleID=\"s66\"><Data ss:Type=\"String\">Kategori Paling Banyak</Data></Cell>
            </Row>";
            $n1 = 0;
            foreach($kabkotas as $kabkota) {
                $n1++;
                $w.="<Row ss:AutoFitHeight=\"0\" ss:Height=\"23.25\">
                    <Cell ss:StyleID=\"s65\"><Data ss:Type=\"Number\">".$n1."</Data></Cell>
                    <Cell ss:StyleID=\"s65\"><Data ss:Type=\"String\">".$kabkota->kab_kota."</Data></Cell>
                    <Cell ss:StyleID=\"s65\"><Data ss:Type=\"Number\">".$kabkota->jumlah_laporan."</Data></Cell>
                    <Cell ss:StyleID=\"s65\"><Data ss:Type=\"String\">".explode('-', $kabkota->kategori_paling_banyak)[0]." (".explode('-', $kabkota->kategori_paling_banyak)[1].")</Data></Cell>
                </Row>";
            }
            $w.="</Table>
            <WorksheetOptions xmlns=\"urn:schemas-microsoft-com:office:excel\">
            <PageSetup>
                <Header x:Margin=\"0.3\"/>
                <Footer x:Margin=\"0.3\"/>
                <PageMargins x:Bottom=\"0.75\" x:Left=\"0.7\" x:Right=\"0.7\" x:Top=\"0.75\"/>
            </PageSetup>
            <Selected/>
            <Panes>
                <Pane>
                <Number>3</Number>
                <ActiveRow>10</ActiveRow>
                <ActiveCol>2</ActiveCol>
                </Pane>
            </Panes>
            <ProtectObjects>False</ProtectObjects>
            <ProtectScenarios>False</ProtectScenarios>
            </WorksheetOptions>
            </Worksheet>
            </Workbook>";
    
            force_download("data_laporan_mingguan".date('Ymd')."_".date('Hi').".xls", $w);
?>